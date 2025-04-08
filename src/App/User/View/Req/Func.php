<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\View\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Config, Trl};
use Core\Plugins\Name\{UserGroup, UserStatus};
use Core\Plugins\{Ssl, View\Tpl, Crypt\CryptText};
use Core\Plugins\Check\{GroupAccess, IntPageAlias};
use Core\Plugins\Name\User\Type;

class Func
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';

    public function checkAccess()
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                IntPageAlias::check() !== false &&
                Auth::getUserStatus() == 1 &&
                (
                    (Auth::getUserId() === IntPageAlias::check()
                    ) ||
                    (GroupAccess::check([3, 4, 5]) &&
                        in_array($this->getViewedUser()['group'], [0, 1, 2], true) === true
                    ) ||
                    (GroupAccess::check([4, 5]) &&
                        $this->getViewedUser()['group'] < Auth::getUserGroup()
                    )
                )
            ) {
                $this->checkAccess =  true;
            }
        }

        return $this->checkAccess;
    }

    private $viewedUser = 'null';
    /**
     * @return mixed // array or false
     */
    public function getViewedUser()
    {
        if ($this->viewedUser === 'null') {
            $userId = IntPageAlias::check();
            $this->viewedUser = is_int($userId) ? Auth::getCustomUser($userId) : false;
        }

        return $this->viewedUser;
    }

    private $user = [];

    private function user(): array
    {
        if ($this->user == []) {

            $user = json_decode($this->getViewedUser()['user'], true);

            $this->user['name']        = $user['name'] != '' ? CryptText::getI()->textDecrypt($user['name']) : '';
            $this->user['middle_name'] = $user['middle_name'] != '' ? CryptText::getI()->textDecrypt($user['middle_name']) : '';
            $this->user['surname']     = $user['surname'] != '' ? CryptText::getI()->textDecrypt($user['surname']) : '';
            $this->user['phone']       = CryptText::getI()->textDecrypt($user['phone']);
            $this->user['email']       = CryptText::getI()->textDecrypt($user['email']);
            $this->user['avatar']      = isset($user['avatar']) ? $user['avatar'] : '';
            $this->user['youtube']     = isset($user['youtube']) ? $user['youtube'] : '';
            $this->user['website']     = isset($user['website']) ? $user['website'] : '';
            $this->user['soc_net_page'] = isset($user['soc_net_page']) ? $user['soc_net_page'] : '';

            $this->user['phone'] = $this->user['phone'] == $this->getViewedUser()['ref_code'] ? '' : $this->user['phone'];
            unset($user);
        }

        return $this->user;
    }
    /**
     * Return full way path user`s avatar
     * @return string
     */
    private function userAvatar(): string
    {
        if ($this->user()['avatar'] != '') {
            return '/' . Config::getCfg('CFG_USER_AVATAR_PATH') . '/' .
                date("Y", $this->getViewedUser()['created']) . '/' .
                date("m", $this->getViewedUser()['created']) . '/' .
                date("d", $this->getViewedUser()['created']) . '/' .
                $this->getViewedUser()['id'] . '/' . $this->user()['avatar'];
        } else {
            return '';
        }
    }

    public function getViewedUserFullName()
    {
        return ($this->user()['name'] != '' ?
            $this->user()['name'] . ' ' . $this->user()['middle_name'] . ' ' . $this->user()['surname'] :
            Trl::_('USER_USER') . ' #' . IntPageAlias::check()
        );
    }

    public function getViewedUserFullNameForAll()
    {
        if ((int) $this->getViewedUser()['type'] === 1) {

            return ($this->user()['name'] != '' ?
                $this->user()['name'] . ' ' . $this->user()['middle_name'] . ' ' . $this->user()['surname'] :
                Trl::_('USER_USER') . ' #' . IntPageAlias::check()
            );
            #
        } else {

            $surname = $this->user()['surname'] == '' ? '' : mb_str_split($this->user()['surname'])[0]  . '.';

            return ($this->user()['name'] != '' ?
                $this->user()['name'] . ' ' . $surname :
                Trl::_('USER_USER') . ' #' . IntPageAlias::check()
            );
        }
    }

    public function getViewViewedUser()
    {
        return Tpl::view(
            PATH_APP . 'User' . DS . 'View' . DS . 'inc' . DS . 'view.php',
            [
                'userFullName'   => $this->getViewedUserFullName(),
                'toEditedLink'   => $this->getViewedUserToEditedLink(),
                'userId'         => $this->getViewedUser()['id'],
                // 'type'           => Type::getColor($this->getViewedUser()['type']),
                'userStatusName' => $this->userStatusName(),
                'userGroupName'  => $this->getGroupName(),
                'user_email'     => $this->user()['email'],
                'user_phone'     => $this->user()['phone'],
                'avatar'         => $this->userAvatar(),
                'youtube'        => $this->user()['youtube'],
                'website'        => $this->user()['website'],
                'soc_net_page'   => $this->user()['soc_net_page'],
                'balance'        => $this->getViewedUser()['type'] == 1 && (IntPageAlias::check() === Auth::getUserId() || GroupAccess::check([3, 4, 5])) ? $this->getViewedUser()['balance'] : '',
                'userCreated'    => userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $this->getViewedUser()['created']),
                'latestEdited'   => $this->getViewedUserEdited(),
                'latestVisit'    => $this->getViewedUserLatestVisit(),
            ]
        );
    }

    public function getViewToAllUser()
    {
        return Tpl::view(
            PATH_APP . 'User' . DS . 'View' . DS . 'inc' . DS . 'toAll.php',
            [
                'userFullName' => $this->getViewedUserFullNameForAll(),
                'avatar'       => $this->userAvatar(),
                'userId'       => $this->getViewedUser()['id'],
                'youtube'      => $this->user()['youtube'],
                'website'      => $this->user()['website'],
                'soc_net_page' => $this->user()['soc_net_page'],
                'userCreated'  => userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $this->getViewedUser()['created']),
            ]
        );
    }

    private function userStatusName()
    {
        if (
            $this->getViewedUser()['id'] == Auth::getUserId() ||
            (Auth::getUserGroup() > 2 &&
                $this->getViewedUser()['group'] < Auth::getUserGroup() &&
                Auth::getUserStatus() == 1
            )
        ) {
            return UserStatus::getColor($this->getViewedUser()['status']);
        } else {
            return '';
        }
    }

    private function getGroupName()
    {
        if (
            $this->getViewedUser()['id'] == Auth::getUserId()
            || (Auth::getUserGroup() > 2
                && $this->getViewedUser()['group'] < Auth::getUserGroup()
                && Auth::getUserStatus() == 1
            )
        ) {

            return UserGroup::getGroupName($this->getViewedUser()['group']);
        } else {

            return '';
        }
    }

    private function getViewedUserEdited()
    {
        if (
            (IntPageAlias::check() === Auth::getUserId()
            )
            || (Auth::getUserGroup() > 2
                && ($this->getViewedUser()['group'] < Auth::getUserGroup())
            )
        ) {

            return userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $this->getViewedUser()['edited']);
        } else {

            return '';
        }
    }

    private function getViewedUserLatestVisit()
    {
        if (
            IntPageAlias::check() === Auth::getUserId() ||
            (Auth::getUserGroup() > 2 &&
                $this->getViewedUser()['group'] < Auth::getUserGroup()
            )
        ) {
            return userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $this->getViewedUser()['latest_visit']);
        } else {
            return '';
        }
    }

    private function getViewedUserToEditedLink()
    {
        if (
            (IntPageAlias::check() === Auth::getUserId()
                || (Auth::getUserGroup() > 2
                    && $this->getViewedUser()['group'] < Auth::getUserGroup()
                )
            )
            && Auth::getUserStatus() == 1
        ) {

            return '<a href="' . Ssl::getLinkLang() . 'user/edit/' . IntPageAlias::check() . '.html" class="uk-text-primary" uk-icon="icon: file-edit"></a>';
        } else {

            return '';
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
