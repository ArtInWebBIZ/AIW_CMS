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

class DepName
{
    private static $allDepName = [];

    public static function getName($value)
    {
        return Trl::_(array_search($value, self::getAllPhotoSize()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllPhotoSize());
    }

    private static function getAllPhotoSize()
    {
        if (self::$allDepName == []) {
            self::$allDepName = require PATH_INC . 'photoPrint' . DS . 'depName.php';
        }

        return self::$allDepName;
    }

    public static function getColor($value)
    {
        $params = [
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
            return '<span class="uk-text-' . $params[$value] . '">' . self::getName($value) . '</span>';
        } else {
            return self::getName($value);
        }
    }
}
