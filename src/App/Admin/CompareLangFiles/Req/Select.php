<?php

namespace App\Admin\CompareLangFiles\Req;

defined('AIW_CMS') or die;

use Core\Languages as CoreLanguages;
use Core\Plugins\Select\OptionTpl;
use Core\Plugins\Select\Other\Languages;

class Select
{
    private static $allValues = null;
    private static $langFileList = null;

    /**
     * Get in array params for select
     * @return array
     */
    private static function getAllValues(): array
    {
        if (self::$allValues === null) {
            self::$allValues = Languages::getI()->clear();
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
     * Return language files list
     * @return array
     */
    public static function clearFiles(): array
    {
        if (self::$langFileList === null) {

            $files = scandir(PATH_LANG . CoreLanguages::langCodeList()[0]);
            unset($files[0], $files[1]);

            self::$langFileList = $files;
        }

        return self::$langFileList;
    }
    /**
     * Get correct select html code
     * @param mixed $fieldValue
     * @return string
     */
    public static function optionFiles(mixed $fieldValue = null): string
    {
        return OptionTpl::labelFromValue(self::clearFiles(), $fieldValue);
    }
}
