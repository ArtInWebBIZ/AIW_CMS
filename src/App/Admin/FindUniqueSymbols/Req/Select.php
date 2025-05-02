<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Admin\FindUniqueSymbols\Req;

defined('AIW_CMS') or die;

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

            $files = scandir(PATH_INC . 'crypt' . DS . 'alphabet');
            unset($files[0], $files[1]);

            self::$allValues = [];

            foreach ($files as $key => $value) {
                $label = str_replace('.php', '', $value);
                self::$allValues[$label] = $value;
            }
            unset($key, $value);
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
