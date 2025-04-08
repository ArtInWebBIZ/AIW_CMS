<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\NewUser\Req;

defined('AIW_CMS') or die;

use Core\{Auth, BaseUrl, Config, Session, Trl};
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\{Ssl, ParamsToSql, Dll\User, View\Tpl, Check\Item, Model\DB};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\View\Style;

class Func
{
    private $checkDataFromPost = [];
    private $newUserId         = 'null';
    private static $instance   = null;

    private function __construct()
    {
    }

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';

    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() === 1 &&
                GroupAccess::check([5])
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    public function checkDataFromPost()
    {
        if ($this->checkDataFromPost == []) {
            $this->checkDataFromPost = (new \Core\Plugins\Check\FormFields)->getCheckFields($this->getFieldsList());
        }

        return $this->checkDataFromPost;
    }

    public function getAddUserForm()
    {
        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'section_css'         => Style::form()['section_css'],
                'container_css'       => Style::form()['container_css'],
                'overflow_css'        => Style::form()['overflow_css'],
                'h_margin'            => Style::form()['h_margin'],
                'button_div_css'      => Style::form()['button_div_css'],
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'title'               => 'TITLE_CONSTANT', // or null
                'v_image'             => null, // or image path
                'include_after_form'  => '', // include after form
                'enctype'      => false, // false or true
                'title'        => 'USER_ADD',
                'url'          => 'user/new-user/',
                'cancel_url'   => null,
                'fields'       => $this->getFieldsList(),
                'button_label' => 'USER_ADD',
            ]
        );
    }

    private function getFieldsList(): array
    {
        return require PATH_APP . 'User' . DS . 'NewUser' . DS . 'inc' . DS . 'fields.php';
    }

    private $checkNewUserEmail = 'null';

    public function checkNewUserEmail(): int
    {
        if ($this->checkNewUserEmail == 'null') {

            $this->checkNewUserEmail = (int) DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'id',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'email_hash' => GetHash::getEmailHash($this->checkDataFromPost()['email']),
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkNewUserEmail;
    }

    private $checkNewUserPhone = 'null';

    public function checkNewUserPhone(): int
    {
        if ($this->checkNewUserPhone == 'null') {

            $this->checkNewUserPhone = (int) DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'id',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'phone_hash' => GetHash::getDefHash($this->checkDataFromPost()['phone']),
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkNewUserPhone;
    }

    public function addUser(): int
    {
        if ($this->newUserId === 'null') {

            $this->newUserId = User::getI()->addUser([
                'name'        => $this->checkDataFromPost()['name'],
                'email'       => $this->checkDataFromPost()['email'],
                'phone'       => $this->checkDataFromPost()['phone'],
            ]);
        }

        return $this->newUserId;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
