<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Order;

defined('AIW_CMS') or die;

use Core\Plugins\Name\Order\Order;
use Core\Trl;

class OrderOption
{
    private static $instance = null;
    private static $allOrder = null;

    private function __construct() {}

    public static function getI(): OrderOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllOrder(): array
    {
        if (self::$allOrder === null) {
            self::$allOrder = require PATH_INC . 'order' . DS . 'order.php';
        }

        return self::$allOrder;
    }

    public function clear(): array
    {
        return self::getAllOrder();
    }

    public function option($orderBy = 'null')
    {
        $variable = $this->clear();

        $selected = $orderBy == 'null' ? ' selected="selected"' : '';

        $optionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value === $orderBy ? ' selected="selected"' : '';
            $optionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Order::getName($value) . '</option>';
        }

        return $optionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
