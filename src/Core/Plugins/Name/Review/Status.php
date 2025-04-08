<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name\Review;

defined('AIW_CMS') or die;

use Core\Trl;

class Status
{
    private static $allStatus = [];

    public static function getStatusName($value)
    {
        return Trl::_(array_search($value, self::getAllStatus()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllStatus());
    }

    private static function getAllStatus()
    {
        if (self::$allStatus == []) {
            self::$allStatus = require PATH_INC . 'review' . DS . 'status.php';
        }

        return self::$allStatus;
    }

    public static function getColor($value)
    {
        $params = [
            0 => 'warning',
            1 => 'success',
            2 => 'danger',
        ];

        if (isset($params[$value])) {
            return '<span class="uk-text-' . $params[$value] . '">' . self::getStatusName($value) . '</span>';
        } else {
            return self::getStatusName($value);
        }
    }
}
