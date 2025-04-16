<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Name\Review;

defined('AIW_CMS') or die;

use Core\Trl;

class Fields
{
    private static $allFields = [];

    public static function getName($value)
    {
        return Trl::_(array_search($value, self::getAllFields()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllFields());
    }

    private static function getAllFields()
    {
        if (self::$allFields == []) {
            self::$allFields = require PATH_INC . 'review' . DS . 'fields.php';
        }

        return self::$allFields;
    }
}
