<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\ChangePass\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Clean, Config, GV};
use Core\Plugins\{ParamsToSql, Model\DB, View\Tpl};
use Core\Plugins\Check\IntPageAlias;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;
use Comp\User\Lib\User;

class Func
{
    private static $instance  = null;
    private $getEditedUser    = 'null';
    private $saveNewPassword  = 'null';
    private $checkNewPassword = 'null';
    private $oldPassHash      = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check users access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if (
            is_int(IntPageAlias::check()) &&
            IntPageAlias::check() === Auth::getUserId() &&
            Auth::getUserStatus() === ForAll::compIncFile('User', 'status')['USER_ACTIVE']
        ) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Return to content form for users change password
     * @return string
     */
    public function getChangePassForm(): string
    {
        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'             => false, // false or true
                'section_css'         => Style::form()['section_css'],
                'container_css'       => Style::form()['container_css'], // container style
                'overflow_css'        => Style::form()['overflow_css'],
                'h_margin'            => Style::form()['h_margin'], // title style
                'button_div_css'      => Style::form()['button_div_css'], // buttons div style
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'v_image'             => null, // or image path
                'include_after_form'  => '', // include after form
                'title'               => 'USER_CHANGE_PASSWORD',
                'url'                 => 'user/change-pass/' . Auth::getUserId() . '.html',
                'cancel_url'          => null, // or '/controller/action/'
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'USER_CHANGE_PASSWORD',
            ]
        );
    }
    /**
     * Get all currently users params
     * @return array|boolean // array or false
     */
    private function getEditedUser(): array|bool
    {
        if ($this->getEditedUser === 'null') {

            $this->getEditedUser = DB::getI()->getRow(
                [
                    'table_name' => 'user',
                    'where'      => '`id` = :id',
                    'array'      => ['id' => Auth::getUserId()],
                ]
            );
        }

        return $this->getEditedUser;
    }
    /**
     * Check old users password
     * @return boolean
     */
    public function checkOldPassword(): bool
    {
        if (
            User::getI()->userPasswordHash(Clean::password(GV::post()['old_password'])) ==
            $this->getEditedUser()['password']
        ) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Get hash old users password
     * @return string
     */
    public function oldPassHash(): string
    {
        if ($this->oldPassHash == 'null') {
            $this->oldPassHash = $this->getEditedUser()['password'];
        }

        return $this->oldPassHash;
    }
    /**
     * Check new users password
     * Return passwords hash or false
     * @return string|bool
     */
    public function checkNewPassword(): string|bool
    {
        if ($this->checkNewPassword == 'null') {

            $newPassword = Clean::password(GV::post()['new_password']);

            if (
                iconv_strlen($newPassword) > Config::getCfg('CFG_MIN_PASS_LEN') &&
                iconv_strlen($newPassword) < Config::getCfg('CFG_MAX_PASS_LEN')
            ) {
                $this->checkNewPassword = User::getI()->userPasswordHash($newPassword);
            } else {
                $this->checkNewPassword = false;
            }
        }

        return $this->checkNewPassword;
    }
    /**
     * Check confirmed value of new users password
     * @return boolean
     */
    public function checkConfirmNewPassword(): bool
    {
        if (
            User::getI()->userPasswordHash(Clean::password(GV::post()['password_confirm'])) ===
            $this->checkNewPassword()
        ) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Save new users password to database
     * @return boolean
     */
    public function saveNewPassword(): bool
    {
        if ($this->saveNewPassword === 'null') {

            $this->saveNewPassword = User::getI()->updUserFromParams(
                [
                    'password' => $this->checkNewPassword(),
                    'edited'   => time(),
                ],
                [
                    'id' => Auth::getUserId(),
                ]
            );
        }

        return $this->saveNewPassword;
    }
    /**
     * Save to log table message about change users password
     * @return integer
     */
    public function saveChangeToLog(): int
    {
        return DB::getI()->add(
            [
                'table_name' => 'user_edit_log',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'edited_id'    => Auth::getUserId(),
                        'editor_id'    => Auth::getUserId(),
                        'edited_field' => 'password',
                        'old_value'    => '***** old password *****',
                        'new_value'    => '***** new password *****',
                        'edited'       => time(),
                    ]
                ),
                'array'      => $set,
            ]
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
