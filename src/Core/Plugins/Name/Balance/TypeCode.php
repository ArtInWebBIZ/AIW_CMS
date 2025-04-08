<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name\Balance;

defined('AIW_CMS') or die;

use Core\Trl;

class TypeCode
{
    private static $allContentTypes = [];

    private static function getAllContentTypes()
    {
        if (self::$allContentTypes == []) {
            self::$allContentTypes = require PATH_INC . 'balance' . DS . 'contentType.php';
        }

        return self::$allContentTypes;
    }

    public static function getNameKey(int $value)
    {
        return array_search($value, self::getAllContentTypes());
    }

    public static function getName(int $value)
    {
        return Trl::_(array_search($value, self::getAllContentTypes()));
    }

    public static function getColor(int $value)
    {
        $params = [
            0 => 'success',
            1 => 'primary',
        ];

        if (isset($params[$value])) {
            return '<span class="uk-text-' . $params[$value] . '">' . self::getName($value) . '</span>';
        } else {
            return self::getName($value);
        }
    }
}
