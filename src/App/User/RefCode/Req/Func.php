<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\RefCode\Req;

defined('AIW_CMS') or die;

use Core\Plugins\{ParamsToSql, Model\DB, View\Tpl};
use Core\Plugins\Check\IntPageAlias;

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
                $this->getViewedUser() != [] &&
                in_array($this->getGroup(), [2, 3, 4, 5], true) === true &&
                $this->getStatus() === 1
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    public function viewCode()
    {
        return Tpl::view(
            PATH_APP . 'User' . DS . 'RefCode' . DS . 'inc' . DS . 'view.php',
            ['ref_code' => $this->getRefCode(),]
        );
    }

    public function getStatus()
    {
        return (int) $this->getViewedUser()['status'];
    }

    public function getRefCode()
    {
        return (string) $this->getViewedUser()['ref_code'];
    }

    public function getGroup()
    {
        return (int) $this->getViewedUser()['group'];
    }

    private $getViewedUser = 'null';

    public function getViewedUser()
    {
        if ($this->getViewedUser == 'null') {

            $this->getViewedUser = DB::getI()->getNeededField(
                [
                    'table_name'          => 'user',
                    'field_name'          => 'ref_code`,`group`,`status',
                    'where'               => ParamsToSql::getSql(
                        $where = ['id' => IntPageAlias::check(),]
                    ),
                    'array'               => $where,
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => 'ASC',
                    'offset'              => 0,
                    'limit'               => 1,
                ]
            );

            $this->getViewedUser = $this->getViewedUser != [] ? $this->getViewedUser[0] : [];
        }

        return $this->getViewedUser;
    }

    private function __clone() {}
    public function __wakeup() {}
}
