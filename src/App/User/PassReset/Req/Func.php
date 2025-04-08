<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\PassReset\Req;

defined('AIW_CMS') or die;

use Core\{Clean, Config, GV, Modules\Randomizer, Plugins\Ssl, Session, Trl,};
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\{ParamsToSql, View\Tpl, Model\DB, Dll\User,};
use Core\Plugins\View\Style;

class Func
{
    private $newPass                  = '';
    private $saveToPassResetNote      = null;
    private $checkUserEmail           = null;
    private $getPassResetNoteFromCode = null;

    private static $instance = null;

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

    public function getAccess()
    {
        return Session::getUserId() == 0 ? true : false;
    }

    public function getView()
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

    private $checkForm = [];

    public function checkForm(): array
    {
        if ($this->checkForm == []) {

            $this->checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require PATH_APP . 'User' . DS . 'PassReset' . DS . 'inc' . DS . 'fields.php'
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

    public function getNewPass()
    {
        if ($this->newPass == '') {
            $this->newPass = Randomizer::getRandomStr(6, 8);
        }

        return $this->newPass;
    }

    public function saveToPassResetNote()
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

    private $setResetCode = 'null';
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

    private $getPassResetNote = 'null';

    public function getPassResetNote()
    {
        if ($this->getPassResetNote === 'null') {

            $this->getPassResetNote = DB::getI()->getValue(
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

    public function checkCode()
    {
        return (iconv_strlen(Clean::str(GV::get()['reset_code'])) != 32) ? false : Clean::str(GV::get()['reset_code']);
    }

    public function getPassResetNoteFromCode()
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

    public function delPassResetNote(int $userId)
    {
        return DB::getI()->delete(
            [
                'table_name' => 'pass_reset_note',
                'where'      => '`user_id` = :user_id',
                'array'      => ['user_id' => $userId],
            ]
        );
    }

    public function updateUserProfile(int $userId, array $params)
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

    public function saveToUserEditLog(array $params)
    {
        return DB::getI()->add(
            [
                'table_name' => 'user_edit_log',
                'set'        => ParamsToSql::getSet($params),
                'array'      => $params,
            ]
        );
    }

    public function sendEmail()
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

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
