<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Router;

class ItemParams
{
    private static $itemParams = 'null';
    /**
     * Return item parameters
     * @return mixed // item params array or false
     */
    public static function itemParams(): array|false
    {
        if (self::$itemParams == 'null') {

            $path = PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'itemParams.php';

            if (file_exists($path)) {
                $itemParams = require $path;
            } else {
                $itemParams = false;
            }

            self::$itemParams = $itemParams;
        }

        return self::$itemParams;
    }
}
