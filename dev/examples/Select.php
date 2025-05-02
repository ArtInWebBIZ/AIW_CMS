<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace PasteNameSpace; // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\Select\OptionTpl;

class Select
{
    private static $allValues = null;
    /**
     * Get in array params for select
     * @return array
     */
    private static function getAllValues(): array
    {

        if (self::$allValues === null) {
            self::$allValues = require ForAll::compIncPath('ControllerName', 'fileName'); // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
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
    /**
     * e.g. get the correct values considering the user group
     * @return array
     */
    public function clearForm(): array // FUNCTION IS EXAMPLE 
    {
        // ALL VALUES IS EXAMPLE  !!! CHANGE_THIS !!!

        if (GroupAccess::check([5])) {
            return self::getAllValues();
        } else {
            $valuesList = [];
            foreach (self::getAllValues() as $key => $value) {
                if (
                    $value === 0 ||
                    $value === 1
                ) {
                    $valuesList[$key] = $value;
                } else {
                    continue;
                }
            }
            return $valuesList;
        }
    }
    /**
     * Get correct select html code
     * @param mixed $fieldValue
     * @return string
     */
    public static function optionForm(mixed $fieldValue = null): string // FUNCTION IS EXAMPLE 
    {
        return OptionTpl::labelFromKey(self::clearForm(), $fieldValue);
    }
}
