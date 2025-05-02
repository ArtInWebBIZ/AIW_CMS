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

class Status
{
    private static $allStatus = [];
    /**
     * Get current users status name
     * @param [type] $value
     * @return string
     */
    public static function getStatusName(int $value): string
    {
        $value = array_search($value, self::getAllStatus());

        return Trl::_($value === false ? 'INFO_NO_CORRECT_FIELD_VALUE' : $value);
    }
    /**
     * Get all user`s status
     * @return array
     */
    private static function getAllStatus(): array
    {
        if (self::$allStatus == []) {
            self::$allStatus = require ForAll::compIncPath('User', 'status');
        }

        return self::$allStatus;
    }
    /**
     * Get current user`s status in colors
     * @param integer $value
     * @return string
     */
    public static function getColor(int $value): string
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
