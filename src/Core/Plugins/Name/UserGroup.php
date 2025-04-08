<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name;

defined('AIW_CMS') or die;

use Core\Trl;

class UserGroup
{
    private static $allGroup = [];

    public static function getGroupName($value)
    {
        return Trl::_(array_search($value, self::getAllGroups()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllGroups());
    }

    private static function getAllGroups()
    {
        if (self::$allGroup == []) {
            self::$allGroup = require PATH_INC . 'user' . DS . 'group.php';
        }

        return self::$allGroup;
    }
}
