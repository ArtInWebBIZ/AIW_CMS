<?php

namespace Core\Plugins\Name\Competition;

use Core\Trl;

defined('AIW_CMS') or die;

class Category
{
    private static $allCategory = [];

    private static function getAllCategory()
    {
        if (self::$allCategory == []) {
            self::$allCategory = array_flip(require PATH_INC . 'competition' . DS . 'category.php');
        }

        return self::$allCategory;
    }

    public static function getNames(string $names)
    {
        $names = explode(",", $names);

        $okNames = [];

        foreach ($names as $key => $value) {
            $okNames[$key] = Trl::_(self::getAllCategory()[$key]);
        }

        return implode(", ", $okNames);
    }
}
