<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\User\Lib;

defined('AIW_CMS') or die;

use Core\{Clean, Config, GV};
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

class Check extends User
{
    private static $instance   = null;
    private $checkParentId     = 'null';
    private $checkNewUserEmail = 'null';
    private $checkNewUserPhone = 'null';

    private function __construct() {}

    public static function getI(): Check
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return parent user ID
     * @return integer
     */
    public function checkParentId(): int
    {
        if ($this->checkParentId == 'null') {

            $this->checkParentId = 1;

            if (
                isset(GV::cookie()['ref_code']) ||
                isset(GV::get()['ref_code'])
            ) {

                $refCode = isset(GV::cookie()['ref_code']) ? GV::cookie()['ref_code'] : Clean::str(GV::get()['ref_code']);

                if (
                    is_string($refCode) &&
                    iconv_strlen($refCode) >= Config::getCfg('CFG_MIN_REF_CODE_LEN') &&
                    iconv_strlen($refCode) <= Config::getCfg('CFG_MAX_REF_CODE_LEN')
                ) {

                    $parentId = DB::getI()->getValue(
                        [
                            'table_name' => 'user',
                            'select'     => 'id',
                            'where'      => '`ref_code` = :ref_code',
                            'array'      => ['ref_code' => $refCode],
                        ]
                    );

                    if ($parentId !== null) {
                        $this->checkParentId = $parentId;
                    }
                }
            }
        }

        return $this->checkParentId;
    }
    /**
     * Check new users email
     * @param string $email
     * @return integer // users ID or 0
     */
    public function checkUserEmail(string $email): int
    {
        if ($this->checkNewUserEmail == 'null') {

            $this->checkNewUserEmail = (int) DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'id',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'email_hash' => GetHash::getEmailHash($email),
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkNewUserEmail;
    }
    /**
     * Check new users phone
     * @param string $phone
     * @return integer // users ID or 0
     */
    public function checkUserPhone(string $phone = ''): int
    {
        if ($this->checkNewUserPhone == 'null') {

            $this->checkNewUserPhone = (int) DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'id',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'phone_hash' => GetHash::getDefHash($phone),
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkNewUserPhone;
    }

    private function __clone() {}
    public function __wakeup() {}
}
