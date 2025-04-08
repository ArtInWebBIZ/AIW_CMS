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

class Crop
{
    private static $allCrop = [];

    public static function getCropName($value)
    {
        return Trl::_(array_search($value, self::getAllCrop()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllCrop());
    }

    private static function getAllCrop()
    {
        if (self::$allCrop == []) {
            self::$allCrop = require PATH_INC . 'photoPrint' . DS . 'crop.php';
        }

        return self::$allCrop;
    }

    public static function getColor($value)
    {
        $params = [
            0 => 'primary', // не оплачено
            1 => 'success', // оплачено
        ];

        if (isset($params[$value])) {
            return '<span class="uk-text-' . $params[$value] . '">' . self::getCropName($value) . '</span>';
        } else {
            return self::getCropName($value);
        }
    }
}
