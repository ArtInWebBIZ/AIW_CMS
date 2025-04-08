<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name;

defined('AIW_CMS') or die;

// (use new \Core\Plugins\Name\TicketType)

use Core\Trl;

class TicketType
{
    private static $allTypes = [];

    private static function getAllTypes()
    {
        if (self::$allTypes == []) {
            self::$allTypes = require PATH_INC . 'ticket' . DS . 'type.php';
        }

        return self::$allTypes;
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllTypes());
    }

    public static function getTypeName($value)
    {
        return Trl::_(array_search($value, self::getAllTypes()));
    }
}
