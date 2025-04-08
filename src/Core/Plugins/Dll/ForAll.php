<?php

namespace Core\Plugins\Dll;

defined('AIW_CMS') or die;

use Core\BaseUrl;
use Core\Config;
use Core\Languages;
use Core\Plugins\Ssl;
use Core\Router;
use Core\Session;

class ForAll
{
    private static $contIncPath  = 'null';
    private static $sitemapOrder = null;
    private static $robots       = null;
    /**
     * Get in array currently content status last,
     * or default items content status list
     * @return array
     */
    public static function contentStatus(string $controllerUrl = null): array
    {
        $controllerDir = $controllerUrl === null ? Router::getRoute()['controller_url'] : $controllerUrl;

        if (
            file_exists(PATH_INC . $controllerDir . DS . 'status.php')
        ) {
            return require PATH_INC . $controllerDir . DS . 'status.php';
        } else {
            return require PATH_INC . 'item' . DS . 'status.php';
        }
    }
    /**
     * Get in array params list from needed file
     * @param string|null $controllerUrl
     * @param string|null $paramsFile
     * @return array
     */
    public static function valueFromKey(string $controllerUrl = null, string $paramsFile = null): array
    {
        $controllerDir = $controllerUrl === null ? Router::getRoute()['controller_url'] : $controllerUrl;
        $paramsFile    = $paramsFile === null ? 'status' : $paramsFile;

        if (
            file_exists(PATH_INC . $controllerDir . DS . $paramsFile . '.php')
        ) {
            return require PATH_INC . $controllerDir . DS . $paramsFile . '.php';
        } else {
            return require PATH_INC . 'item' . DS . $paramsFile . '.php';
        }
    }
    /**
     * Return correctly path to inc directory for this content type
     * @return string
     */
    public static function contIncPath(): string
    {
        if (self::$contIncPath === 'null') {
            self::$contIncPath = PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS;
        }

        return self::$contIncPath;
    }
    /**
     * Return sitemap order for this content type
     * @return int
     */
    public static function sitemapOrder(): int
    {
        if (self::$sitemapOrder === null) {

            self::$sitemapOrder = 0;

            if (file_exists(PATH_INC . 'for-all' . DS . 'sitemap.php')) {

                $orderList = require PATH_INC . 'for-all' . DS . 'sitemap.php';

                if (isset($orderList[Router::getRoute()['controller_name']][Router::getRoute()['action_name']])) {
                    self::$sitemapOrder = $orderList[Router::getRoute()['controller_name']][Router::getRoute()['action_name']]['order'];
                }
                #
            }
            #
        }

        return self::$sitemapOrder;
    }
    /**
     * Return in string actual meta robots value
     * @return string
     */
    public static function robots(int $robotsKey = 100): string
    {
        if (self::$robots === null) {

            self::$robots = 'noindex, nofollow';

            if ($robotsKey === 100) {

                $orderList = require PATH_INC . 'for-all' . DS . 'sitemap.php';

                if (isset($orderList[Router::getRoute()['controller_name']][Router::getRoute()['action_name']])) {
                    self::$robots = $orderList[Router::getRoute()['controller_name']][Router::getRoute()['action_name']]['robots'];
                }
                #
            } else {

                $allRobots = require PATH_INC . 'for-all' . DS . 'robots.php';
                self::$robots = $allRobots[$robotsKey];
                #
            }
        }

        return self::$robots;
    }
    /**
     * Return default canonical link about content languages is
     * greater of one
     * @return string
     */
    public static function canonical(string $defLang = 'null'): string
    {
        if (count(Languages::langList()) > 1) {

            $lang       = $defLang === 'null' ?  Languages::langList()[0][0] . '/' : $defLang . '/';
            $controller = Router::getRoute()['controller_url'] != '' ? Router::getRoute()['controller_url'] . '/' : '';
            $action     = Router::getRoute()['action_url'] != '' ? Router::getRoute()['action_url'] . '/' : '';
            $pageAlias  = Router::getRoute()['page_alias'] != '' ? Router::getRoute()['page_alias'] . '.html' : '';

            return '<link rel="canonical" href="' . Config::getCfg('http_type') . Config::getCfg('site_host') . '/' . $lang . $controller . $action . $pageAlias . '">';
            #
        } else {
            return '';
        }
    }
    /**
     * Return meta alternate link for NOT item content type
     * @return string
     */
    public static function alternate(string $defLang = 'null'): string
    {
        if (count(Languages::langList()) == 1) {

            return '
                <link rel="alternate" hreflang="' . Session::getLang() . '" href="' . Ssl::getLink() . BaseUrl::getBaseUrl() . '" />
                <link rel="alternate" hreflang="x-default" href="' . Ssl::getLink() . BaseUrl::getBaseUrl() . '" />';
            #
        } else {

            $link = '';

            foreach (Languages::langCodeList() as $key => $value) {
                $link .= '<link rel="alternate" hreflang="' . $value . '" href="' . Ssl::getLink() . '/' . $value . '/' . BaseUrl::getOnlyUrl() . '" />';
            }
            unset($key, $value);

            $lang = $defLang === 'null' ? Languages::langCodeList()[0] : $defLang;

            $link .= '<link rel="alternate" hreflang="x-default" href="' . Ssl::getLink() . '/' . $lang . '/' . BaseUrl::getOnlyUrl() . '" />';

            return $link;
        }
    }
}
