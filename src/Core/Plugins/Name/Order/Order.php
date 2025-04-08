<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name\Order;

defined('AIW_CMS') or die;

use Core\Trl;

class Order
{
    private static $allOrder = [];

    public static function getName($value)
    {
        return Trl::_(array_search($value, self::getAllOrder()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllOrder());
    }

    private static function getAllOrder()
    {
        if (self::$allOrder == []) {
            self::$allOrder = require PATH_INC . 'order' . DS . 'order.php';
        }

        return self::$allOrder;
    }
}
