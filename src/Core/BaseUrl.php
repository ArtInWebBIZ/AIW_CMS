<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\{Clean, Router, Session, Languages};

class BaseUrl
{
    private static $baseUrl       = 'null';
    private static $fullUrl       = null;
    private static $setBaseUrl    = null;
    private static $setFullUrl    = null;
    private static $getOnlyUrl    = 'null';
    private static $getLangToLink = 'null';

    private static function setFullUrl()
    {
        if (self::$setFullUrl === null) {

            $get = iconv_strlen(Router::getGetStr()) > 0 ? '?' . Router::getGetStr() : '';

            self::$setFullUrl = self::setBaseUrl() . $get;
        }

        return self::$setFullUrl;
    }

    private static function setBaseUrl()
    {
        if (self::$setBaseUrl === null) {

            $controllerUrl = iconv_strlen(Router::getRoute()['controller_url']) > 0 ? Router::getRoute()['controller_url'] . '/' : '';
            $actionUrl     = iconv_strlen(Router::getRoute()['action_url']) > 0 ? Router::getRoute()['action_url'] . '/' : '';

            $pageAlias = Clean::name(Router::getRoute()['page_alias']);
            $pageAlias = iconv_strlen($pageAlias) > 0 ? $pageAlias . '.html' : '';

            self::$setBaseUrl = $controllerUrl . $actionUrl . $pageAlias;
        }

        return self::$setBaseUrl;
    }

    public static function getFullUrl()
    {
        if (self::$fullUrl === null) {
            self::$fullUrl = self::getLangToLink() . self::setFullUrl();
        }

        return self::$fullUrl;
    }

    public static function getBaseUrl()
    {
        if (self::$baseUrl === 'null') {
            self::$baseUrl = self::getLangToLink() . self::setBaseUrl();
        }

        return self::$baseUrl;
    }

    public static function getOnlyUrl()
    {
        if (self::$getOnlyUrl === 'null') {
            self::$getOnlyUrl = self::setBaseUrl();
        }

        return self::$getOnlyUrl;
    }

    public static function getLangPageUrl($lang)
    {
        return '/' . $lang . '/' . self::setBaseUrl();
    }


    public static function getLangToLink()
    {
        if (self::$getLangToLink === 'null') {

            if (count(Languages::langList()) > 1) {
                self::$getLangToLink = '/' . Session::getLang() . '/';
            } else {
                self::$getLangToLink = '/';
            }
        }

        return self::$getLangToLink;
    }
}
