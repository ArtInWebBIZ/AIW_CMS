<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Plugins\Model\DB;
use Core\Router;

class Controller
{
    private static $currControllerName = 'null';
    /**
     * Return controllers list or false
     * @return array // array or []
     */
    public static function getList(): array
    {
        $getControllerList = DB::getI()->getAll(
            [
                'table_name'          => 'item_controller',
                'where'               => '`id` > :id',
                'array'               => ['id' => 0],
                'order_by_field_name' => 'id',
                'order_by_direction'  => 'ASC', // DESC
                'offset'              => 0,
                'limit'               => 0, // 0 - unlimited
            ]
        );

        if ($getControllerList != []) {

            $list = [];

            foreach ($getControllerList as $key => $value) {
                $list[$getControllerList[$key]['controller_url']] = $getControllerList[$key];
            }

            $getControllerList = $list;
        }

        return $getControllerList;
    }
    /**
     * Return current controllers ID or false
     * @return mixed // integer ID or false
     */
    public static function currControllerId(): mixed
    {
        $currControllerId = false;

        if (isset(self::getList()[self::currControllerName()])) {
            $currControllerId = (int) self::getList()[Item::getI()->currControllerName()]['id'];
        }

        return $currControllerId;
    }
    /**
     * Return currently controllers name
     * @return string
     */
    public static function currControllerName(): string
    {
        if (self::$currControllerName === 'null') {
            self::$currControllerName = str_replace("-", "_", Router::getRoute()['controller_url']);
        }

        return self::$currControllerName;
    }
}
