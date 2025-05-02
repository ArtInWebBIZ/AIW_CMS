<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Login\Req;

defined('AIW_CMS') or die;

use Comp\User\Lib\User;
use Core\{Clean, GV, Trl};
use Core\Modules\Msg;
use Core\Plugins\Create\Menu\Menu;
use Core\Plugins\{ParamsToSql, Ssl, Model\DB, View\Tpl};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;

class Func
{
    private $user            = [];
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
     * Get users params in associative array or boolean false
     * @return array|bool // array or false
     */
    public function getUser(): array|bool
    {
        if ($this->user == []) {
            $this->user = User::getI()->getUserFromEmail(Clean::email(GV::post()['login_email']));
        }
        return $this->user;
    }

    public function checkUserPassword()
    {
        if (
            User::getI()->userPasswordHash(Clean::password(GV::post()['login_password'])) ===
            $this->getUser()['password']
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function noCorrectEmailOrPassword()
    {
        return Msg::getI()->getMsg('warning', Trl::_('USER_NO_CORRECT_EMAIL_PASSWORD'));
    }

    public function viewLoginForm()
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
                'title'               => 'USER_LOGIN',
                'url'                 => 'user/login/',
                'cancel_url'          => 'hidden',
                'v_image'             => null,
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'USER_LOGIN',
                'include_after_form'  => Menu::getI()->createMenu(require PATH_INC . 'menu' . DS . 'betweenLogin.php'),
            ]
        );
    }

    public function deleteOtherUsersSession()
    {
        return DB::getI()->delete(
            [
                'table_name' => 'session',
                'where'      => ParamsToSql::getSql(
                    $where = ['user_id' => $this->getUser()['id']]
                ),
                'array'      => $where,
            ]
        );
    }

    public function sendEmailAboutLogin()
    {
        $link = Ssl::getLinkLang() . 'user/pass-reset/';

        return (new \Core\Modules\Email)->sendEmail(
            Clean::email(GV::post()['login_email']),
            Trl::_('EMAIL_NEW_LOGIN_SUBJECT'),
            Trl::_('EMAIL_NEW_LOGIN_TEXT') . '<p><a href="' . $link . '">' . $link . '</a></p>'
        );
    }

    public function deleteRecordInActivationTable()
    {
        return DB::getI()->delete(
            [
                'table_name' => 'activation',
                'where'      => ParamsToSql::getSql(
                    $where = ['user_id' => $this->getUser()['id']]
                ),
                'array'      => $where,
            ]
        );
    }

    public function referer()
    {
        if (isset(GV::post()['referer'])) {

            $referer = GV::post()['referer'];
            /**
             * Check correct host
             */
            if (str_contains($referer, Ssl::getLinkLang())) {
                /**
                 * Return correct referrers link
                 */
                return Clean::url($referer);
                #
            } else {
                return Ssl::getLinkLang();
            }
            #
        } else {
            return Ssl::getLinkLang();
        }
    }

    private function __clone() {}

    public function __wakeup() {}
}
