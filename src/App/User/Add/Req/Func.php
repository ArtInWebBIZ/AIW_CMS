<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Add\Req;

defined('AIW_CMS') or die;

use Comp\User\Lib\User;
use Core\{Config, Session, Trl};
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\{Ssl, ParamsToSql, View\Tpl, Model\DB};
use Core\Plugins\Check\CheckForm;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;

class Func
{
    private $newUserId         = null;
    private static $instance   = null;
    private $checkAccess = 'null';
    private $checkForm = [];
    private $checkNewUserEmail = 'null';
    private $checkUserIp = null;

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
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Session::getUserId() == 0 &&
                Session::getTmpStatus() == -1
            ) {

                $this->checkAccess = true;
                #
            }
        }

        return $this->checkAccess;
    }
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    public function checkForm(): array
    {
        if ($this->checkForm == []) {
            $this->checkForm = CheckForm::check(ForAll::contIncPath() . 'fields.php');
        }

        return $this->checkForm;
    }
    /**
     * Return add form
     * @return string
     */
    public function viewForm(): string
    {
        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'             => false, // false or true
                'section_css'         => Style::form()['section_css'],
                'container_css'       => Style::form()['container_css'],
                'overflow_css'        => Style::form()['overflow_css'],
                'h_margin'            => Style::form()['h_margin'],
                'button_div_css'      => Style::form()['button_div_css'],
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'v_image'             => null, // or image path
                'include_after_form'  => '', // include after form
                'title'               => 'USER_ADD',
                'url'                 => 'user/add/',
                'cancel_url'          => null,
                'fields'              => ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'USER_ADD',
            ]
        );
    }
    /**
     * Return old users id or zero
     * @return integer
     */
    public function checkNewUserEmail(): int
    {
        if ($this->checkNewUserEmail == 'null') {

            $this->checkNewUserEmail = (int) DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'id',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'email_hash' => GetHash::getEmailHash($this->checkForm()['email']),
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkNewUserEmail;
    }
    /**
     * Return empty array ([]) or latest users ID register from this IP
     * @return array|integer
     */
    public function checkUserIp(): array|int
    {
        if ($this->checkUserIp === null) {

            $this->checkUserIp = DB::getI()->getNeededField(
                [
                    'table_name'          => 'activation',
                    'field_name'          => 'user_id',
                    'where'               => ParamsToSql::getSql(
                        $where = ['user_ip' => Session::getUserIp()]
                    ),
                    'array'               => $where,
                    'order_by_field_name' => 'user_id',
                    'order_by_direction'  => 'DESC',
                    'offset'              => 0,
                    'limit'               => 1,
                ]
            );

            $this->checkUserIp = $this->checkUserIp != [] ? $this->checkUserIp[0] : [];
        }

        return $this->checkUserIp;
    }
    /**
     * Add new user to website database
     * Return new users id
     * @return integer
     */
    public function addUser(): int
    {
        if ($this->newUserId === null) {

            $this->newUserId = User::getI()->addUser([
                'email' => $this->checkForm()['email'],
                'type'  => $this->checkForm()['type'],
            ]);
        }

        return $this->newUserId;
    }
    /**
     * Update current users session
     * Return in array new Session::getSession
     * @return array
     */
    public function sessionUpdate(): array
    {
        return Session::updSession(
            [
                'tmp_status'   => 0,
                'save_session' => 1,
                'enabled_to'   => time() + Config::getCfg('CFG_MAX_SESSION_TIME'),
            ]
        );
    }
    /**
     * Save users activations value to activation table in database
     * @return bool
     */
    public function saveToActivationTable(): bool
    {
        return User::getI()->saveToActivationTable($this->addUser());
    }
    /**
     * Send in email to new user yours password for login to website
     * @return boolean
     */
    public function sendEmail(): bool
    {
        $to      = $this->checkForm()['email'];
        $subject = Trl::_('EMAIL_CONFIRM');
        $message = Trl::sprintf(
            'EMAIL_CREATE_NEW_USER',
            ...[
                Ssl::getLinkLang() . 'user/login/',
                Ssl::getLinkLang() . 'user/login/',
                User::getI()->generateUserPass(),
                Ssl::getLinkLang() . 'contacts/',
            ]
        );

        // toTmp(User::getI()->generateUserPass());

        return (new \Core\Modules\Email)->sendEmail($to, $subject, $message);
    }

    private function __clone() {}
    public function __wakeup() {}
}
