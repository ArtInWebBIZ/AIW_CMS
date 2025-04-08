<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name\PhotoPrint;

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
            self::$allStatus = require PATH_INC . 'photoPrint' . DS . 'status.php';
        }

        return self::$allStatus;
    }

    public static function getColor($value)
    {
        $params = [
            -1 => 'danger', // не оплачено
            0 => 'danger', // не оплачено
            1 => 'warning', // оплачено
            2 => 'primary', // выполняется
            3 => 'primary', // выполняется
            4 => 'primary', // выполняется
            5 => 'primary', // выполняется
            6 => 'primary', // выполняется
            7 => 'primary', // выполняется
            8 => 'success', // отправлено
            9 => 'danger', // выполнено
        ];

        if (isset($params[$value])) {
            return '<span class="uk-text-' . $params[$value] . '">' . self::getStatusName($value) . '</span>';
        } else {
            return self::getStatusName($value);
        }
    }
}
