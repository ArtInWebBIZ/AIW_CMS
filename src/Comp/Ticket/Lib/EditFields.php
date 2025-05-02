<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Ticket\Lib;

defined('AIW_CMS') or die;

use Core\Trl;

class EditFields
{
    private static $allTypes = [];

    private static function getAllTypes()
    {
        if (self::$allTypes == []) {
            self::$allTypes = require PATH_INC . 'ticket' . DS . 'fields.php';
        }

        return self::$allTypes;
    }

    public static function getName($value)
    {
        return Trl::_(array_search($value, self::getAllTypes()));
    }
}
