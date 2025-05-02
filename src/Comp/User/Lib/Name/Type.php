<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\User\Lib\Name;

defined('AIW_CMS') or die;

use Core\Plugins\Lib\ForAll;
use Core\Trl;

class Type
{
    private static $allStatus = [];
    /**
     * Get all user type`s
     * @return array
     */
    private static function getAllType(): array
    {
        if (self::$allStatus == []) {
            self::$allStatus = require ForAll::compIncPath('User', 'type');
        }

        return self::$allStatus;
    }
    /**
     * Get current user`s type name
     * @param integer $value
     * @return string
     */
    public static function getTypeName(int $value): string
    {
        $value = array_search($value, self::getAllType());

        return Trl::_($value === false ? 'INFO_NO_CORRECT_FIELD_VALUE' : $value);
    }
    /**
     * Get in color current user`s type name
     * @param integer $value
     * @return string
     */
    public static function getColor(int $value): string
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
