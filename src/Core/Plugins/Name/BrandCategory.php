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

class BrandCategory
{
    private static $allCategories = [];

    private static function getAllCategories()
    {
        if (self::$allCategories == []) {
            self::$allCategories = require PATH_INC . 'brand' . DS . 'categories.php';
        }

        return self::$allCategories;
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllCategories());
    }

    public static function getCategoryName($value)
    {
        return Trl::_(array_search($value, self::getAllCategories()));
    }
}
