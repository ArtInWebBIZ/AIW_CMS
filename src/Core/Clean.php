<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core;

use Core\Plugins\Check\CleanHtml;

defined('AIW_CMS') or die;

class Clean
{
    /**
     * Return prepare value from form
     * @param string $value
     * @return string
     */
    private static function _prepare($value)
    {
        $value = strval($value);
        $value = stripslashes($value);
        $value = str_ireplace(['\0', '\a', '\b', '\v', '\e', '\f'], ' ', $value);

        return htmlspecialchars_decode($value, ENT_QUOTES);
    }
    /**
     * Return prepare value from form
     * @param string $value
     * @return string
     */
    public static function raw($value): string
    {
        $value = self::_prepare($value);
        $value = str_ireplace("\"", '&quot;', $value);
        return $value;
    }
    /**
     * Return boolean value or null
     * @param void $value
     * @return boolean
     * @return null
     */
    public static function bool(bool $bool)
    {
        if (gettype($bool) == 'boolean') {
            return $bool;
        } else {
            return null;
        }
    }
    /**
     * Return correct integer
     * @param string $value
     * @return int
     * @return false
     */
    public static function int(string $value): mixed
    {
        $int = self::_prepare(strval($value));
        $int = mb_ereg_replace('[\s]', '', $int);
        $int = preg_replace('/[^0-9]/', '', $int);
        $int = mb_strlen($value) > 0 && $value[0] === '-' ? '-' . $int : $int;
        return $int == '' || $int == '-' ? false : (int) $int;
    }
    /**
     * Return correct unsigned integer
     * @param string $value
     * @return int
     * @return false
     */
    public static function unsInt(string $value): int|bool
    {
        $int = self::_prepare(strval($value));
        $int = mb_ereg_replace('[\s]', '', $int);
        $int = preg_replace('/[^0-9]/', '', $int);
        $int = str_replace('-', '', $int);
        return mb_strlen($value) > 0 ? (int) $int : false;
    }
    /**
     * Floating point number. May be negative.
     */
    public static function float($value, $default = 0): float
    {
        $value = self::_prepare($value);
        $value = mb_ereg_replace('[\s]', '', $value);
        $value = str_replace(',', '.', $value);
        $value = floatval($value);
        return (empty($value)) ? $default : $value;
    }
    /**
     * Price.
     */
    public static function price($value, $default = null)
    {
        $value = self::_prepare($value);
        $value = mb_ereg_replace('[^0-9\.,]', '', $value);
        $value = mb_ereg_replace('[,]+', ',', $value);
        $value = mb_ereg_replace('[.]+', '.', $value);
        $pos_1 = mb_strpos($value, '.');
        $pos_2 = mb_strpos($value, ',');
        if ($pos_1 && $pos_2) {
            $value = mb_substr($value . '00', 0, $pos_1 + 3);
            $value = str_replace(',', '', $value);
        } elseif ($pos_1) {
            $value = mb_substr($value . '00', 0, $pos_1 + 3);
        } elseif ($pos_2) {
            if ((mb_strlen($value) - $pos_2) == 3) {
                $value = str_replace(',', '.', $value);
            } else {
                $value = str_replace(',', '', $value) . '.00';
            }
        } elseif (mb_strlen($value) == 0) {
            return $default;
        } else {
            $value = $value . '.00';
        }

        return ($value == '0.00') ? 0 : $value;
    }
    /**
     * Return correct html text
     * @param string $value
     * @return string
     */
    public static function text(string $value)
    {
        $value = self::_prepare($value);
        $value = str_ireplace(["\t"], ' ', $value);
        $value = preg_replace([
            '@<\!--.*?-->@s',
            '@\/\*(.*?)\*\/@sm',
            '@<([\?\%]) .*? \\1>@sx',
            '@<\!\[CDATA\[.*?\]\]>@sx',
            '@<\!\[.*?\]>.*?<\!\[.*?\]>@sx',
            '@\s--.*@',
            '@<script[^>]*?>.*?</script>@si',
            '@<style[^>]*?>.*?</style>@siU',
        ], ' ', $value);
        $value = strip_tags($value, CleanHtml::allTagsInString());
        $value = CleanHtml::cleanTags($value);
        $value = str_replace(['/*', '*/', ' --', '#__'], ' ', $value);
        $value = mb_ereg_replace('[ ]+', ' ', $value);
        $value = str_ireplace("\"", '&quot;', $value);
        $value = trim($value);
        return (mb_strlen($value) == 0) ? '' : $value;
    }
    /**
     * Return correct string value
     * @param string $value
     * @return string
     */
    public static function str(string $value)
    {
        $value = self::text($value);
        $value = mb_ereg_replace('[\s]+', ' ', $value);
        $value = str_ireplace("\"", '&quot;', $value);
        $value = strip_tags($value);
        $value = trim($value);
        return (mb_strlen($value) == 0) ? '' : $value;
    }
    /**
     * Return correct username and other names
     * @param string $value
     * @return string
     * @return false
     */
    public static function name(string $value)
    {
        $value = self::str($value);
        $value = str_replace(['%', '!', '@', '#', '$', '^', '&', '*', '(', ')', '_', '+', '=', ':', ';', '"', '\'', '\\', '|', '<', '>', ',', '.', '?', '`', '~', '[', ']', '{', '}', '/'], '', $value);
        return (mb_strlen($value) == 0) ? false : $value;
    }
    /**
     * Return correct ulr
     * @param string $value
     * @return string
     */
    public static function url(string $value)
    {
        if ($value == '') {
            return '';
        } else {
            $search = ['%20', '%3c', '%3e', '%22', '\'', '%60', ',', ';', '`', '@', '"', '^', '(', ')', '[', ']', '{', '}', '|', '%', '~', '#', '<', '>'];
            $value  = str_replace($search, '', $value);
            $value  = self::text($value);
            $value  = str_ireplace(["\r", "\n"], '', $value);
            $value  = mb_ereg_replace('[\s]+', ' ', $value);

            do {
                $value = str_ireplace(["////", "///", "//"], '/', $value);
            } while (is_int(strpos($value, '//')));

            $value = str_ireplace(['http:/', 'https:/'], Config::getCfg('http_type'), $value);

            $value = trim($value);
            return (mb_strlen($value) == 0) ? '' : $value;
        }
    }
    /**
     * Return correct link or false
     * @param string $value
     * @return string
     * @return false
     */
    public static function link(string $value)
    {
        if ($value == '') {
            return '';
        } else {
            $search = ['%20', '%3c', '%3e', '%22', '\'', '%60', ','];
            $link   = str_replace($search, '', $value);
            // $link   = strtolower(self::str($link));
            $link   = str_ireplace(["\r", "\n", " "], '', $link);
            $link   = str_ireplace(["http://", "https://"], '', $link);
            $link   = trim(mb_ereg_replace('[\s]+', '', $link));
            return (mb_strlen($link) != 0) ? 'https://' . $link : false;
        }
    }
    /**
     * Return correct filename or false
     * @param string $value
     * @return string
     * @return false
     */
    public static function filename($value)
    {
        if ($value == '') {
            return false;
        } else {
            $value = self::str($value);
            $value = str_replace(['/', '|', '\\', '?', ':', ';', '\'', '"', '<', '>', '*'], '', $value);
            $value = mb_ereg_replace('[.]+', '.', $value);
            return (mb_strlen($value) == 0) ? false : $value;
        }
    }
    /**
     * Return Unix timestamp
     * @param string $value
     * @return integer
     * @return false
     */
    public static function time($value)
    {
        $value = self::str($value);
        $value = strtotime($value);
        return (empty($value)) ? false : $value;
    }
    /**
     * Return correct email or false
     * @param string $value
     * @return string
     * @return false
     */
    public static function email(string $value)
    {
        $email    = '';
        $email    = explode("@", self::str($value));
        $email[0] = self::name($email[0]);
        $email    = implode("@", $email);

        if (!preg_match('|^[-0-9A-Za-z_\.]+@[-0-9A-Za-z^\.]+\.[a-z]{2,6}$|i', $email)) {
            return false;
        } else {
            return strtolower($email);
        }
    }
    /**
     * Return correct password
     * @param string $value
     * @return string
     * @return false
     */
    public static function password(string $value)
    {
        $password = '';
        $password = self::str($value);
        $password = preg_replace("/[^0-9a-z\.`~!@#$%\^&\*_\?\+\\\|=-\[\]\{\}\(\)<>\/]/i", "", $password);
        return (!empty($password) ? $password : false);
    }
    /**
     * Check value
     * @param mixed $value
     * @param string $func
     * @return mixed
     */
    public static function check(mixed $value, string $func): mixed
    {
        if ($func == 'raw') {
            $value = self::raw($value);
        } elseif ($func == 'bool') {
            $value = self::bool($value);
        } elseif ($func == 'int') {
            $value = self::int($value);
        } elseif ($func == 'unsInt') {
            $value = self::unsInt($value);
        } elseif ($func == 'float') {
            $value = self::float($value);
        } elseif ($func == 'price') {
            $value = self::price($value);
        } elseif ($func == 'text') {
            $value = self::text($value);
        } elseif ($func == 'str') {
            $value = self::str($value);
        } elseif ($func == 'name') {
            $value = self::name($value);
        } elseif ($func == 'url') {
            $value = self::url($value);
        } elseif ($func == 'link') {
            $value = self::link($value);
        } elseif ($func == 'filename') {
            $value = self::filename($value);
        } elseif ($func == 'time') {
            $value = self::time($value);
        } elseif ($func == 'email') {
            $value = self::email($value);
        } elseif ($func == 'password') {
            $value = self::password($value);
        } else {
            $value = self::_prepare($value);
        }

        if (
            $value === null
        ) {
            $value = false;
        }

        return $value;
    }
}
