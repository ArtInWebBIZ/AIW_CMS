<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\User\Lib;

defined('AIW_CMS') or die;

use Core\Modules\Randomizer;
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\{ParamsToSql, Crypt\CryptText, Model\DB};
use Core\{Session, Config};

class User
{
    private static $instance      = null;
    private $getNotActivatedUsers = null;
    private $generateUserPass     = 'null';
    private $newRefCode           = 'null';

    private function __construct() {}

    public static function getI(): User
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return new user ID or 0
     * @param array $params
     * Obligatory keys:
     * $params['type'];
     * $params['email']
     * @return integer
     */
    public function addUser(array $params): int
    {
        $params = [
            'parent_id'   => Check::getI()->checkParentId(),
            'ref_code'    => $this->newRefCode(),
            'type'        => isset($params['type']) ? $params['type'] : 0,
            'email_hash'  => GetHash::getEmailHash($params['email']),
            'phone_hash'  => isset($params['phone']) ? GetHash::getDefHash($params['phone']) : GetHash::getDefHash($this->newRefCode()),
            'user'        => json_encode(
                [
                    'name'        => isset($params['name']) ? CryptText::getI()->textEncrypt($params['name']) : '',
                    'middle_name' => isset($params['middle_name']) ? CryptText::getI()->textEncrypt($params['middle_name']) : '',
                    'surname'     => isset($params['surname']) ? CryptText::getI()->textEncrypt($params['surname']) : '',
                    'phone'       => isset($params['phone']) ? CryptText::getI()->textEncrypt($params['phone']) : CryptText::getI()->textEncrypt($this->newRefCode()),
                    'email'       => CryptText::getI()->textEncrypt($params['email']),
                ]
            ),
            'password'    => $this->userPasswordHash($this->generateUserPass()),
        ];

        $defValue = [
            'status'       => 0,
            'created'      => time(),
            'edited'       => time(),
            'latest_visit' => time(),
            'lang'         => Session::getLang(),
        ];

        return DB::getI()->add(
            [
                'table_name' => 'user',
                'set'        => ParamsToSql::getSet($params) . ', ' . ParamsToSql::getSet($defValue),
                'array'      => array_merge($params, $defValue),
            ]
        );
    }
    /**
     * Update User Status
     * @param integer $userId
     * @param integer $status
     * @return boolean
     */
    public function updateUserStatus(int $userId, $status = 1): bool
    {
        return DB::getI()->update(
            [
                'table_name' => 'user',
                'set'        => '
                    `edited_count` = `edited_count` + 1,
                    `status` = :status,
                    `edited` = :edited
                ',
                'where'      => '`id` = :id',
                'array'      => [
                    'status' => $status,
                    'edited' => time(),
                    'id'     => $userId,
                ],
            ]
        );
    }
    /**
     * Save changed user parameters to users edit log
     * @param array $params
     * @return integer // id or 0
     */
    public function saveToEditLog(array $params): int
    {
        /** [
         *     'edited_id'    => 'value',
         *     'editor_id'    => 'value',
         *     'edited_field' => 'value',
         *     'old_value'    => 'value',
         *     'new_value'    => 'value',
         *     'edited'       => 'value',
         * ] */
        return (int) DB::getI()->add(
            [
                'table_name' => 'user_edit_log',
                'set'        => ParamsToSql::getSet($params),
                'array'      => $params,
            ]
        );
    }
    /**
     * Delete not activation users
     * @return boolean
     */
    public function deleteNotActivatedUsers(): bool
    {
        if ($this->getNotActivatedUsers() != []) {
            /**
             * Save change user status to edit log
             */
            $in = '';

            foreach ($this->getNotActivatedUsers() as $key => $value) {

                $in .= ':id_' . $key . ',';
                $inToArray[':id_' . $key] = $this->getNotActivatedUsers()[$key]['user_id'];
            }

            $in = substr($in, 0, -1);
            /**
             * Delete not activated users
             */
            return DB::getI()->delete(
                [
                    'table_name' => 'user',
                    'where'      => '`id` IN (' . $in . ')',
                    'array'      => $inToArray,
                ]
            );
            #
        } else {
            return true;
        }
    }
    /**
     * Get not activated users
     * @return array
     */
    private function getNotActivatedUsers(): array
    {
        if ($this->getNotActivatedUsers == null) {
            /**
             * Get in array not activated users id
             */
            $this->getNotActivatedUsers = DB::getI()->getNeededField(
                [
                    'table_name'          => 'activation',
                    'field_name'          => 'user_id',
                    'where'               => '`enabled_to` < :enabled_to',
                    'array'               => ['enabled_to' => time()],
                    'order_by_field_name' => 'user_id',
                    'order_by_direction'  => 'ASC', // DESC
                    'offset' => 0,
                    'limit'               => 0,
                ]
            );
        }

        return $this->getNotActivatedUsers;
    }
    /**
     * Get hash users password
     * @param string $password
     * @return string
     */
    public function userPasswordHash(string $password): string
    {
        return GetHash::getPassHash($password);
    }
    /**
     * Save users activation code to database
     * @param integer $userId
     * @return boolean
     */
    public function saveToActivationTable(int $userId): bool
    {
        return DB::getI()->boolAdd(
            [
                'table_name' => 'activation',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'user_id'    => $userId,
                        'user_ip'    => Session::getUserIp(),
                        'enabled_to' => time() + Config::getCfg('CFG_USER_ACTIVATION_TIME'),
                    ]
                ),
                'array'      => $set,
            ]
        );
    }
    /**
     * Generate new users password
     * @return string
     */
    public function generateUserPass(): string
    {
        if ($this->generateUserPass === 'null') {
            $this->generateUserPass = Randomizer::getRandomStr(8, 12);
        }

        return $this->generateUserPass;
    }
    /**
     * Check user from email
     * @param string $email
     * @return array|bool // array or false
     */
    public function getUserFromEmail(string $email): array|bool
    {
        return DB::getI()->getRow(
            [
                'table_name' => 'user',
                'where'      => '`email_hash` = :email_hash',
                'array'      => ['email_hash' => GetHash::getEmailHash($email)],
            ]
        );
    }
    /**
     * Generate users referrals code
     * @return string
     */
    private function newRefCode(): string
    {
        if ($this->newRefCode === 'null') {

            do {

                $this->newRefCode = Randomizer::getRandomStr(
                    Config::getCfg('CFG_MIN_REF_CODE_LEN'),
                    Config::getCfg('CFG_MAX_REF_CODE_LEN')
                );

                $parentId = DB::getI()->getValue(
                    [
                        'table_name' => 'user',
                        'select'     => 'id',
                        'where'      => '`ref_code` = :ref_code',
                        'array'      => ['ref_code' => $this->newRefCode],
                    ]
                );
                #
            } while ($parentId !== null);
        }

        return $this->newRefCode;
    }
    /**
     * Update users params
     * @param array $set
     * @param array $where
     * @return boolean
     */
    public function updUserFromParams(array $set, array $where): bool
    {
        $count = count($set) - 1;

        return DB::getI()->update(
            [
                'table_name' => 'user',
                'set'        => ParamsToSql::getSet($set) . ', `edited_count` = `edited_count` + ' . $count,
                'where'      => ParamsToSql::getSql($where),
                'array'      => array_merge($set, $where),
            ]
        );
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
