<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\{Config, Session};
use Core\Plugins\Crypt\CryptText;

class Auth
{
    private static $userId = null;
    private static $user   = null;
    private static $status = null;
    private static $getUserUser = null;

    private static function setUserId()
    {
        if (self::$userId === null) {
            self::$userId = Session::getUserId();
        }

        return (int) self::$userId;
    }
    /**
     * Return users id
     * @return int
     */
    public static function getUserId(): int
    {
        return self::setUserId();
    }
    /**
     * Return array users param
     * @return array
     */
    private static function getUser()
    {
        if (self::$user === null) {

            if (self::getUserId() !== 0) {

                self::$user = DB::getRow(
                    "SELECT * FROM `user` WHERE `id` = :id",
                    ['id' => self::getUserId()]
                );

                if (self::$user === false) {

                    self::$user = [];
                    Session::updSession(
                        [
                            'user_id'      => 0,
                            'tmp_status'   => -1,
                            'save_session' => 0,
                            'enabled_to'   => time() + Config::getCfg('CFG_MIN_SESSION_TIME'),
                        ]
                    );
                }
                #
            } else {
                self::$user = [];
            }
        }

        return self::$user;
    }
    /**
     * Get in array value from key ['user']
     * @return array
     */
    public static function getUserUser(): array
    {
        if (self::$getUserUser === null) {
            self::$getUserUser = json_decode(self::getUser()['user'], true);
        }

        return self::$getUserUser;
    }
    /**
     * Getting a row from a table.
     * @return mixed // array or false
     */
    public static function getCustomUser(int $userId = null)
    {
        return DB::getRow(
            "SELECT * FROM `user` WHERE `id` = :id",
            ['id' => $userId]
        );
    }
    /**
     * Return users ref_code
     * @return string
     */
    public static function getUserResCode(): string
    {
        return self::getUser() == [] ? '' : self::getUser()['ref_code'];
    }
    /**
     * Return users name
     * @return string
     */
    public static function getUserName(): string
    {
        return self::getUser() != [] && self::getUserUser()['name'] != '' ? CryptText::getI()->textDecrypt(self::getUserUser()['name']) : '';
    }
    /**
     * Return users name
     * @return string
     */
    public static function getUserLastName(): string
    {
        return self::getUser() != [] && self::getUserUser()['middle_name'] != '' ? CryptText::getI()->textDecrypt(self::getUserUser()['middle_name']) : '';
    }
    /**
     * Return users surname
     * @return string
     */
    public static function getUserSurname()
    {
        return self::getUser() != [] && self::getUserUser()['surname'] != '' ? CryptText::getI()->textDecrypt(self::getUserUser()['surname']) : '';
    }
    /**
     * Return users full name (name + surname)
     * @return string
     */
    public static function getUserFullName(): string
    {
        return trim(self::getUserName() . ' ' . self::getUserLastName() . ' ' . self::getUserSurname());
    }
    /**
     * Return users parent user id
     * @return int
     */
    public static function getUserParentId(): int
    {
        return self::getUser() == [] ? 0 : self::getUser()['parent_id'];
    }
    /**
     * Return users group
     * @return int
     */
    public static function getUserGroup(): int
    {
        return self::getUser() == [] ? 0 : self::getUser()['group'];
    }
    /**
     * Get current user group name
     * @return string
     */
    public static function getUserGroupName()
    {
        return in_array(self::getUserGroup(), require PATH_INC . 'user' . DS . 'group.php');
    }
    /**
     * Return users status
     * @return int
     */
    public static function getUserStatus(): int
    {
        if (self::$status === null) {

            if (
                self::getUser() !== [] &&
                Session::getTmpStatus() != self::getUser()['status']
            ) {
                Session::updSession(['tmp_status' => self::getUser()['status']]);
            }

            self::$status = self::getUser() == [] ? Session::getTmpStatus() : self::getUser()['status'];
        }

        return self::$status;
    }
    /**
     * Return users edit count value or empty string
     * @return string|integer
     */
    public static function getEditedCount(): string|int
    {
        return self::getUser() == [] ? '' : (int) self::getUser()['edited_count'];
    }
    /**
     * Return users created date value or empty string
     * @return string|integer
     */
    public static function getUserCreated(): string|int
    {
        return self::getUser() == [] ? '' : (int) self::getUser()['created'];
    }
    /**
     * Return users type value or empty string
     * @return string|integer
     */
    public static function getUserType(): string|int
    {
        return self::getUser() == [] ? '' : (int) self::getUser()['type'];
    }
    /**
     * Return users email or empty string
     * @return string
     */
    public static function getUserEmail(): string
    {
        return self::getUser() == [] ? '' : CryptText::getI()->textDecrypt(self::getUserUser()['email']);
    }
    /**
     * Return users phone or empty string
     * @return string
     */
    public static function getUserPhone(): string
    {
        return self::getUser() == [] ? '' : CryptText::getI()->textDecrypt(self::getUserUser()['phone']);
    }
    /**
     * Return users avatar link or empty string
     * @return string
     */
    public static function getUserAvatar(): string
    {
        if (self::getUser() == []) {
            return '';
        } else {
            if (
                isset(self::getUserUser()['avatar']) &&
                self::getUserUser()['avatar'] != ''
            ) {
                return '/' . Config::getCfg('CFG_USER_AVATAR_PATH') . '/' .
                    date("Y", self::getUserCreated()) . '/' .
                    date("m", self::getUserCreated()) . '/' .
                    date("d", self::getUserCreated()) . '/' .
                    self::getUserId() . '/' . self::getUserUser()['avatar'];
            } else {
                return '';
            }
        }
        return self::getUser() == [] ? '' : CryptText::getI()->textDecrypt(self::getUserUser()['phone']);
    }
    /**
     * Return users balance or 0
     * @return float
     */
    public static function getUserBalance(): float
    {
        return self::getUser() == [] ? 0 : (float) self::getUser()['balance'];
    }
}
