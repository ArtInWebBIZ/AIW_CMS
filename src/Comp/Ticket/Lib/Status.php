<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Ticket\Lib;

defined('AIW_CMS') or die;

use Core\Trl;

class Status
{
    private static $allStatus = [];

    private static function getAllStatus()
    {
        if (self::$allStatus == []) {
            self::$allStatus = require PATH_INC . 'ticket' . DS . 'status.php';
        }

        return self::$allStatus;
    }

    public static function getStatusName($value)
    {
        return Trl::_(array_search($value, self::getAllStatus()));
    }

    public static function getColor($value)
    {
        $params = [
            0 => 'warning',
            1 => 'primary',
            2 => 'success',
            3 => 'danger',
        ];

        if (isset($params[$value])) {
            return '<span class="uk-text-' . $params[$value] . '">' . self::getStatusName($value) . '</span>';
        } else {
            return self::getStatusName($value);
        }
    }
}
