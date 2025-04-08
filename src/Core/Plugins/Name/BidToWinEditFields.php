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

class BidToWinEditFields
{
    private static $allFields = [];

    private static function getAllFields()
    {
        if (self::$allFields == []) {
            self::$allFields = require PATH_INC . 'btw' . DS . 'fields.php';
        }

        return self::$allFields;
    }

    public static function getName($value)
    {
        return isset(self::getAllFields()[$value]) ? Trl::_(self::getAllFields()[$value]) : $value;
    }
}
