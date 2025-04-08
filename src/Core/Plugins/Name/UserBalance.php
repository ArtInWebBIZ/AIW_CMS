<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name;

defined('AIW_CMS') or die;

use Core\Trl;

class UserBalance
{
    private static $allPaidType = [];

    public static function getPaidTypeName($value)
    {
        return Trl::_(array_search($value, self::getAllPaidType()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllPaidType());
    }

    private static function getAllPaidType()
    {
        if (self::$allPaidType == []) {
            self::$allPaidType = require PATH_INC . 'user' . DS . 'paidType.php';
        }

        return self::$allPaidType;
    }
    public static function getColor($value)
    {
        $params = [
            0 => 'success',
            1 => 'success',
            2 => 'danger',
            3 => 'success',
            4 => 'danger',
            5 => 'danger',
        ];

        if (isset($params[$value])) {
            return '<span class="uk-text-' . $params[$value] . '">' . self::getPaidTypeName($value) . '</span>';
        } else {
            return self::getPaidTypeName($value);
        }
    }
}
