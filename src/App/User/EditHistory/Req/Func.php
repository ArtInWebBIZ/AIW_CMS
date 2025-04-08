<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\EditHistory\Req;

defined('AIW_CMS') or die;

use Core\{Auth, DB};
use Core\Plugins\Check\GroupAccess;


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
                GroupAccess::check([4, 5]) &&
                Auth::getUserStatus() == 1
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private $closedUser = [];

    public function closedUser()
    {
        if ($this->closedUser == []) {

            /**
             * Получаем список id юзеров, рангом выше текущего юзера
             */
            $closedId = DB::getAll(
                "SELECT `id` FROM `user` WHERE `group` >= :group",
                ['group' => Auth::getUserGroup()]
            );

            $closedIdArray = [];
            $closedToSql   = '';

            foreach ($closedId as $key => $value) {
                $closedIdArray['id_' . $key] = (int) $closedId[$key]['id'];
                $closedToSql .= ':id_' . $key . ',';
            }

            $closedToSql = substr(trim($closedToSql), 0, -1);

            $this->closedUser['array'] = $closedIdArray;
            $this->closedUser['sql']   = $closedToSql;
        }

        return $this->closedUser;
    }

    private function __clone() {}
    public function __wakeup() {}
}
