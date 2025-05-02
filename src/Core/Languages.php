<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

class Languages
{
    private static $langListArr  = null;
    private static $langCodeList = null;

    public static function langList(): array
    {
        if (self::$langListArr === null) {
            self::$langListArr = require PATH_INC . 'languages.php';
        }

        return self::$langListArr;
    }

    public static function langCodeList(): array
    {
        if (self::$langCodeList === null) {

            self::$langListArr = self::langList();
            $countLangListArr  = count(self::$langListArr);
            for ($i = 0; $i < $countLangListArr; $i++) {
                $langCodeList[$i] = self::$langListArr[$i][0];
            }
            self::$langCodeList = $langCodeList;
        }

        return self::$langCodeList;
    }

    public static function checkLang(string $lang): bool
    {
        if (in_array($lang, self::langCodeList())) {
            return true;
        } else {
            return false;
        }
    }
}
