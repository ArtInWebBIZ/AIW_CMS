<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Lib;

defined('AIW_CMS') or die;

use Core\{BaseUrl, Config, Languages, Router, Session};
use Core\Plugins\Ssl;

class ForAll
{
    private static $contIncPath  = 'null';
    private static $sitemapOrder = null;
    private static $robots       = null;
    /**
     * Get in array params list from needed file
     * @param string|null $incDir
     * @param string|null $paramsFile
     * @return array
     */
    public static function valueFromKey(string $incDir, string $paramsFile): array
    {
        if (
            file_exists(PATH_INC . $incDir . DS . $paramsFile . '.php')
        ) {
            return require PATH_INC . $incDir . DS . $paramsFile . '.php';
        } else {
            return [];
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
     * Return file from Comp directory
     * @return mixed
     */
    public static function compIncPath(string $controllerName, string $fileName): mixed
    {
        return PATH_COMP . $controllerName . DS . 'inc' . DS . $fileName . '.php';
    }
    /**
     * Return file from Comp directory
     * @return mixed
     */
    public static function compIncFile(string $controllerName, string $fileName): mixed
    {
        return require PATH_COMP . $controllerName . DS . 'inc' . DS . $fileName . '.php';
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
