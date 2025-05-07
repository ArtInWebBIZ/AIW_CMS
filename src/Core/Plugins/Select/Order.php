<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Select;

defined('AIW_CMS') or die;

class Order
{
    private static $allOrder = null;
    /**
     * Get all order`s value
     * @return array
     */
    private static function getAllOrder(): array
    {
        if (self::$allOrder === null) {
            self::$allOrder = require PATH_INC . 'for-all' . DS . 'order.php';
        }

        return self::$allOrder;
    }
    /**
     * Get all order`s value tu all users
     * @return array
     */
    public static function clear(): array
    {
        return self::getAllOrder();
    }
    /**
     * Get correctly options to select field
     * @param [type] $orderBy
     * @return void
     */
    public static function option($orderBy = null)
    {
        return OptionTpl::labelFromKey(self::clear(), $orderBy);
    }
}
