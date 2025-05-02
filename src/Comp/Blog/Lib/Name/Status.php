<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Blog\Lib\Name;

defined('AIW_CMS') or die;

use Core\Plugins\Lib\ForAll;
use Core\Trl;

class Status
{
    private static $allStatus = [];
    /**
     * Get in array all blog`s status
     * @return array
     */
    private static function getAllStatus(): array
    {
        if (self::$allStatus == []) {
            self::$allStatus = require ForAll::compIncPath('Blog', 'status');
        }

        return self::$allStatus;
    }
    /**
     * Return current status name or value, if status incorrect
     * @param integer $value
     * @return string
     */
    public static function getStatusName(int $value): string
    {
        return Trl::_(array_search($value, self::getAllStatus()));
    }
    /**
     * Get blog status name in color
     * @param integer $value
     * @return string
     */
    public static function getColor(int $value): string
    {
        $params = [
            0 => 'warning',
            1 => 'muted',
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
