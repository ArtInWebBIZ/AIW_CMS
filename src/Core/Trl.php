<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\Session;

class Trl
{
    private static $override = [];
    /**
     * Return value in this language
     * @param string $str
     * @return string
     */
    public static function _(string $str): string
    {
        if (self::override($str) == []) {

            return $str;
            #
        } else {

            if (isset(self::$override['text'][$str])) {
                return self::$override['text'][$str];
            } else {
                return $str;
            }
            #
        }
    }
    /**
     * Return value in this language or more params
     * @param string $str
     * @param array  ...$args
     * @return string
     */
    public static function sprintf(string $str, ...$args): string
    {
        if (self::override($str) == []) {

            return $str;
            #
        } else {

            if (isset(self::$override['text'][$str])) {
                return sprintf(self::$override['text'][$str], ...$args);
            } else {
                return $str;
            }
        }
    }
    /**
     * Get in array two parameter
     * @param string $str
     * @return array
     * @return string ['path'] - path to language file
     * @return array ['text] - get all values in this languages file
     */
    private static function override(string $str): array
    {
        $override     = explode("_", $str);
        $override     = strtolower($override[0]);
        $overridePath = PATH_LANG . Session::getLang() . DS . $override . '.php';

        if (
            isset(self::$override['path']) &&
            $overridePath == self::$override['path']
        ) {

            return self::$override;
            #
        } elseif (is_readable($overridePath)) {

            self::$override = [];

            self::$override['path'] = $overridePath;
            self::$override['text'] = require $overridePath;

            return self::$override;
            #
        } else {

            return self::$override = [];
            #
        }
    }
}
