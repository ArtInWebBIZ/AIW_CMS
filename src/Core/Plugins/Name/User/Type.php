<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Name\User;

defined('AIW_CMS') or die;

use Core\Trl;

class Type
{
    private static $allStatus = [];

    public static function getTypeName($value)
    {
        return Trl::_(array_search($value, self::getAllType()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllType());
    }

    private static function getAllType()
    {
        if (self::$allStatus == []) {
            self::$allStatus = require PATH_INC . 'user' . DS . 'type.php';
        }

        return self::$allStatus;
    }
    public static function getColor($value)
    {
        $params = [
            0 => 'success',
            1 => 'warning',
        ];

        if (isset($params[$value])) {
            return '<span class="uk-text-' . $params[$value] . '">' . self::getTypeName($value) . '</span>';
        } else {
            return self::getTypeName($value);
        }
    }
}
