<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\PassReset\Req;

defined('AIW_CMS') or die;

use Core\{Clean, Config, GV, Modules\Randomizer, Plugins\Ssl, Session, Trl,};
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\{ParamsToSql, View\Tpl, Model\DB, Dll\User,};
use Core\Plugins\Dll\ForAll;
use Core\Plugins\View\Style;

class Func
{
    private $newPass                  = '';
    private $saveToPassResetNote      = null;
    private $checkUserEmail           = null;
    private $getPassResetNoteFromCode = null;
    private $checkForm                = [];
    private $setResetCode             = 'null';
    private $getPassResetNote         = 'null';

    private static $instance = null;

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
    public function getAccess(): bool
    {
        return Session::getUserId() == 0 ? true : false;
    }
    /**
     * View form to users pass reset
     * @return string
     */
    public function getView(): string
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
                'include_after_form'  => '', // include after form
                'title'        => 'USER_NEW_PASSWORD', // or null
                'url'          => 'user/pass-reset/',
                'cancel_url'   => 'hidden', // or '/controller/action/' or 'hidden'
                'v_image'      => null, // or image path
                'fields'       => require PATH_APP . 'User' . DS . 'PassReset' . DS . 'inc' . DS . 'fields.php',
                'button_label' => 'USER_SEND_NEW_PASSWORD',
            ]
        );
    }
    /**
     * Undocumented function
     * @return array
     */
    public function checkForm(): array
    {
        if ($this->checkForm === []) {

            $this->checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require ForAll::contIncPath() . 'fields.php'
            );
        }

        return $this->checkForm;
    }
    /**
     * Return User ID or 0
     * @return integer
     */
    public function checkUserEmail(): int
    {
        if ($this->checkUserEmail == null) {

            $this->checkUserEmail = (int) DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'id',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'email_hash' => GetHash::getEmailHash($this->checkForm()['email'])
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkUserEmail;
    }
    /**
     * Create new users password
     * @return string
     */
    public function getNewPass(): string
    {
        if ($this->newPass == '') {
            $this->newPass = Randomizer::getRandomStr(6, 8);
        }

        return $this->newPass;
    }
    /**
     * Save note no database about reset passwords this user
     * @return integer
     */
    public function saveToPassResetNote(): int
    {
        if ($this->saveToPassResetNote === null) {

            $this->saveToPassResetNote = DB::getI()->add(
                [
                    'table_name' => 'pass_reset_note',
                    'set' => ParamsToSql::getSet(
                        $params = [
                            'user_id'      => $this->checkUserEmail(),
                            'reset_code'   => GetHash::getDefHash($this->setResetCode()),
                            'new_password' => User::getI()->userPasswordHash($this->getNewPass()),
                            'enabled_to'   => time() + Config::getCfg('CFG_MIN_SESSION_TIME'),
                        ]
                    ),
                    'array' => $params,
                ]
            );
        }

        return $this->saveToPassResetNote;
    }
    /**
     * Generated new passwords reset code
     * @return string
     */
    public function setResetCode(): string
    {
        if ($this->setResetCode == 'null') {
            $this->setResetCode = Randomizer::getRandomStr(32, 32);
        }

        return $this->setResetCode;
    }
    /**
     * Get users id from pass reset note
     * @return integer
     */
    public function getPassResetNote(): int
    {
        if ($this->getPassResetNote === 'null') {

            $this->getPassResetNote = (int) DB::getI()->getValue(
                [
                    'table_name' => 'pass_reset_note',
                    'select'     => 'user_id',
                    'where'      => ParamsToSql::getSql($where = ['user_id' => $this->checkUserEmail()]),
                    'array'      => $where,
                ]
            );
        }

        return $this->getPassResetNote;
    }
    /**
     * Delete old pass reset note
     * @return boolean
     */
    public function delOldPassResetNote(): bool
    {
        return DB::getI()->delete(
            [
                'table_name' => 'pass_reset_note',
                'where'      => '`enabled_to` < :request_time',
                'array'      => ['request_time' => time()],
            ]
        );
    }
    /**
     * Check activation password reset code
     * @return string|false
     */
    public function checkCode(): string|false
    {
        return (iconv_strlen(Clean::str(GV::get()['reset_code'])) != 32) ? false : Clean::str(GV::get()['reset_code']);
    }
    /**
     * Return in array passwords reset note or false
     * @return array|false
     */
    public function getPassResetNoteFromCode(): array|false
    {
        if ($this->getPassResetNoteFromCode === null) {

            $this->getPassResetNoteFromCode = DB::getI()->getRow(
                [
                    'table_name' => 'pass_reset_note',
                    'where'      => '`reset_code` = :reset_code',
                    'array'      => ['reset_code' => GetHash::getDefHash($this->checkCode())],
                ]
            );
        }

        return $this->getPassResetNoteFromCode;
    }
    /**
     * Delete passwords reset note for this user
     * @param integer $userId
     * @return boolean
     */
    public function delPassResetNote(int $userId): bool
    {
        return DB::getI()->delete(
            [
                'table_name' => 'pass_reset_note',
                'where'      => '`user_id` = :user_id',
                'array'      => ['user_id' => $userId],
            ]
        );
    }
    /**
     * Update users profile
     * @param integer $userId
     * @param array   $params
     * @return boolean
     */
    public function updateUserProfile(int $userId, array $params): bool
    {
        return DB::getI()->update(
            [
                'table_name' => 'user',
                'set'        => ParamsToSql::getSet($params) . ', `edited_count` = `edited_count` + 1',
                'where'      => ParamsToSql::getSql($where = ['id' => $userId]),
                'array'      => array_merge($params, $where),
            ]
        );
    }
    /**
     * Save to log change users password
     * @param array $params
     * @return integer
     */
    public function saveToUserEditLog(array $params): int
    {
        return DB::getI()->add(
            [
                'table_name' => 'user_edit_log',
                'set'        => ParamsToSql::getSet($params),
                'array'      => $params,
            ]
        );
    }
    /**
     * Send to users email code in link for reset users password
     * @return boolean
     */
    public function sendEmail(): bool
    {
        return (new \Core\Modules\Email)->sendEmail(
            GV::post()['email'],
            Trl::_('USER_NEW_PASSWORD') . ' / ' . Trl::_('OV_SITE_NAME'),
            Trl::sprintf(
                'EMAIL_SEND_NEW_PASSWORD',
                ...[
                    $this->getNewPass(),
                    Ssl::getLinkLang() . 'user/pass-reset/?reset_code=' . $this->setResetCode(),
                    Ssl::getLinkLang() . 'user/pass-reset/?reset_code=' . $this->setResetCode(),
                    Ssl::getLinkLang() . 'contacts/',
                ]
            )
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
