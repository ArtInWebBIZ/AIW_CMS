<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Name;

defined('AIW_CMS') or die;

use Core\Trl;

class UserEditFields
{
    private static $allFields = [];

    private static function getAllFields()
    {
        if (self::$allFields == []) {
            self::$allFields = require PATH_INC . 'user' . DS . 'fields.php';
        }

        return self::$allFields;
    }

    public static function getName($value)
    {
        return isset(self::getAllFields()[$value]) ? Trl::_(self::getAllFields()[$value]) : $value;
    }
}
