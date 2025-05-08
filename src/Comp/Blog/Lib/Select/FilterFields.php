<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Blog\Lib\Select;

defined('AIW_CMS') or die;

use Core\Plugins\Select\OptionTpl;
use Core\Plugins\Check\Item\AllItemFields;

class FilterFields
{
    private static $allValues = null;
    /**
     * Get in array params for select
     * @return array
     */
    private static function getAllValues(): array
    {

        if (self::$allValues === null) {
            self::$allValues = array_flip(AllItemFields::getAllItemFieldsName());
        }

        return self::$allValues;
    }
    /**
     * Get in array all correct select values for check values to correct
     * @return array
     */
    public static function clear(): array
    {
        return self::getAllValues();
    }
    /**
     * Get correct select html code
     * @param mixed $fieldValue
     * @return string
     */
    public static function option(mixed $fieldValue = null): string
    {
        return OptionTpl::labelFromKey(self::clear(), $fieldValue);
    }
}
