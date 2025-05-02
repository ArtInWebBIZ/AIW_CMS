<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Ticket\Lib;

defined('AIW_CMS') or die;

use Core\Plugins\Lib\ForAll;
use Core\Trl;

class Type
{
    private static $allTypes = [];

    private static function getAllTypes()
    {
        if (self::$allTypes == []) {
            self::$allTypes = require ForAll::compIncPath('Ticket', 'type');
        }

        return self::$allTypes;
    }

    public static function getTypeName($value)
    {
        return Trl::_(array_search($value, self::getAllTypes()));
    }
}
