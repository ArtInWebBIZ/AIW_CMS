<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\Clean;

class GV
{
    private static $cookie = [];
    private static $post   = [];
    private static $get    = [];
    private static $server = [];
    private static $files  = [];

    public static function cookie()
    {
        if (self::$cookie == []) {

            self::$cookie = $_COOKIE == [] ? null : $_COOKIE;

            $_COOKIE = false;
        }

        return self::$cookie;
    }

    /**
     * Return $_POST values
     * @return mixed array or null
     */
    public static function post()
    {
        if (self::$post == []) {

            self::$post = $_POST == [] ? null : $_POST;

            $_POST = false;
        }

        return self::$post;
    }

    public static function addPost(array $params)
    {
        $post = self::post();

        foreach ($params as $key => $value) {
            $post[$key] = $params[$key];
        }

        return self::$post = $post;
    }
    /**
     * Return @_GET array or null
     * @return array|null
     */
    public static function get(): array|null
    {
        if (self::$get == []) {
            /**
             * If empty GET global variables
             */
            if ($_GET == []) {

                self::$get = null;
                #
            } else {

                foreach ($_GET as $key => $value) {

                    if (iconv_strlen($value) > Config::getCfg('CFG_MAX_GET_VALUES_LEN')) {
                        continue;
                    } else {
                        self::$get[$key] = Clean::str($_GET[$key]);
                    }
                    #
                }
                unset($key, $value);
            }

            $_GET = false;
        }

        return self::$get;
    }

    public static function addToGet(array $params): string
    {
        $getString = '?';

        if (self::get() === null) {

            foreach ($params as $key => $value) {
                $getString .= $key . '=' . $value . '&';
            }
            unset($key, $value);
            #
        } else {

            foreach (self::get() as $key => $value) {

                if (isset($params[$key])) {
                    $newGetArray[$key] = $params[$key];
                    unset($params[$key]);
                } else {
                    $newGetArray[$key] = self::get()[$key];
                }
                #
            }
            unset($key, $value);

            $newGetArray = array_merge($newGetArray, $params);

            foreach ($newGetArray as $key => $value) {
                $getString .= $key . '=' . $value . '&';
            }
            unset($key, $value);
        }

        return mb_substr($getString, 0, -1);
    }

    public static function delGet($params)
    {
        $get = self::get();

        foreach ($params as $key => $value) {
            if (isset($get[$key])) {
                unset($get[$key]);
            }
        }

        return self::$get = $get;
    }

    public static function getToUrl($params = null)
    {
        $get = self::get();

        $getToUrl = '';

        if ($get !== null) {

            foreach ($get as $key => $value) {

                if (isset($params[$key])) {
                    $value = $params[$key];
                    unset($params[$key]);
                }

                $getToUrl .= $key . '=' . $value . '&';
            }
        }

        if ($params !== null) {

            foreach ($params as $key1 => $value1) {

                $getToUrl .= $key1 . '=' . $value1 . '&';
            }
        }

        $getToUrl = substr($getToUrl, 0, -1);

        return $getToUrl != '' ? '?' . $getToUrl : '';
    }

    public static function server()
    {
        return self::$server = $_SERVER == [] ? null : $_SERVER;
    }

    public static function files()
    {
        if (self::$files == []) {

            self::$files = $_FILES == [] ? null : $_FILES;

            $_FILES = false;
        }

        return self::$files;
    }
}
