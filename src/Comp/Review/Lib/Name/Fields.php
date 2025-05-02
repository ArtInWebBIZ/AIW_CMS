<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Review\Lib\Name;

defined('AIW_CMS') or die;

use Core\Plugins\Lib\ForAll;
use Core\Trl;

class Fields
{
    private static $allFields = [];
    /**
     * Get all review`s fields
     * @return array
     */
    private static function getAllFields(): array
    {
        if (self::$allFields == []) {
            self::$allFields = require ForAll::compIncPath('Review', 'fields');
        }

        return self::$allFields;
    }
    /**
     * Return current fields name
     * @param [type] $value
     * @return string
     */
    public static function getName($value): string
    {
        $value = array_search($value, self::getAllFields());

        return Trl::_($value === false ? 'INFO_NO_CORRECT_FIELD_VALUE' : $value);
    }
}
