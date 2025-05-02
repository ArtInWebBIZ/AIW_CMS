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

class Group
{
    private static $allGroup = [];
    /**
     * Get in array all users group
     * @return array
     */
    private static function getAllGroups(): array
    {
        if (self::$allGroup == []) {
            self::$allGroup = require ForAll::compIncPath('User', 'group');
        }

        return self::$allGroup;
    }
    /**
     * Get correctly users group name
     * @param integer $value
     * @return string
     */
    public static function getGroupName(int $value): string
    {
        $value = array_search($value, self::getAllGroups());

        return Trl::_($value === false ? 'INFO_NO_CORRECT_FIELD_VALUE' : $value);
    }
}
