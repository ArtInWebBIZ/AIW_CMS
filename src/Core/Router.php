<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\{Clean, GV, Languages, Config};
use Core\Plugins\Check\GroupAccess;

class Router
{
    private static $prepareUri = [];
    private static $uri        = null;
    private static $uriGET     = 'null';
    private static $route      = [];
    private static $controller = [];
    private static $action     = [];
    private static $pageAlias  = null;

    private static function _prepareUri(): array
    {
        if (self::$prepareUri === []) {
            self::$prepareUri = explode("?", ltrim(trim(Clean::url(substr(GV::server()['REQUEST_URI'], 1))), '/'));
        }

        return self::$prepareUri;
    }

    private static function getUri(): array
    {
        if (self::$uri === null) {
            self::$uri = array_filter(explode('/', strtolower(self::_prepareUri()[0])));
        }

        return self::$uri;
    }

    public static function getGetStr()
    {
        if (self::$uriGET == 'null') {

            if (
                isset(self::_prepareUri()[1]) &&
                iconv_strlen(self::_prepareUri()[1]) > 0
            ) {
                self::$uriGET = self::_prepareUri()[1];
            } else {
                self::$uriGET = '';
            }
        }

        return self::$uriGET;
    }

    public static function getRoute()
    {
        if (self::$route == []) {

            self::checkLang();

            if (
                GV::post() !== null &&
                self::getController()['name'] == 'User' &&
                self::getAction()['name'] == 'Login'
            ) {
                self::route();
                #
            } elseif (
                Config::getCfg('CFG_VIEW_RECONSTRUCTION_PAGE') === true &&
                GroupAccess::check([3, 4, 5]) === false
            ) {
                ob_start();
                require_once PATH_TPL . 'sur.php';
                echo ob_get_clean();
                die;
                #
            } else {
                self::route();
            }
        }

        return self::$route;
    }

    private static function checkLang()
    {
        if (
            count(Languages::langList()) > 1 &&
            isset(self::getUri()[0]) &&
            Languages::checkLang(self::getUri()[0]) &&
            self::getUri()[0] != Session::getLang()
        ) {
            Session::updSession(['lang' => self::getUri()[0]]);
        }
    }

    private static function route()
    {
        self::$route['controller_name'] = self::getController()['name'];
        self::$route['controller_url']  = self::getController()['url'];
        self::$route['action_name']     = self::getAction()['name'];
        self::$route['action_url']      = self::getAction()['url'];
        self::$route['page_alias']      = self::getPageAlias();
    }

    private static function getController()
    {
        if (self::$controller == []) {

            if (self::getUri() == []) {
                self::$controller['name'] = 'Main';
                self::$controller['url']  = '';
                $controllerKey = 0;
            } elseif (Languages::checkLang(self::getUri()[0])) {
                $controllerKey = 1;
            } else {
                $controllerKey = 0;
            }

            if (
                self::$controller == [] &&
                isset(self::getUri()[$controllerKey])
            ) {

                $controllerName = ucfirst(self::getUri()[$controllerKey]);
                $controllerUrl  = strtolower($controllerName);

                if (strpos($controllerName, '-') !== false) {

                    $controllerName = explode("-", $controllerName);

                    foreach ($controllerName as $key1 => $value1) {
                        $controllerName[$key1] = ucfirst($value1);
                    }

                    $controllerName = (string) implode($controllerName);
                }

                if (is_dir(PATH_APP . $controllerName)) {

                    self::$controller['name'] = $controllerName;
                    self::$controller['url']  = $controllerUrl;
                    #
                } else {
                    self::$controller['name'] = 'Main';
                    self::$controller['url']  = '';
                }
                #
            } else {
                self::$controller['name'] = 'Main';
                self::$controller['url']  = '';
            }
            self::$controller['key'] = $controllerKey;
        }

        return self::$controller;
    }

    private static function getAction()
    {
        if (self::$action == []) {

            if (self::getController()['name'] == 'Main') {

                self::$action['name'] = 'Index';
                self::$action['url']  = '';
                self::$action['key']  = 0;
                #
            } else {

                $actionKey = self::getController()['key'] + 1;

                if (
                    isset(self::getUri()[$actionKey]) &&
                    iconv_strlen(self::getUri()[$actionKey]) > 0
                ) {

                    $actionLink = self::getUri()[$actionKey];
                    $actionName = ucfirst($actionLink);

                    if (strpos($actionLink, '-') !== false) {

                        $actionName = explode("-", $actionLink);

                        foreach ($actionName as $key => $value) {
                            $actionName[$key] = ucfirst($value);
                        }

                        $actionName = implode($actionName);
                    }

                    if ( // If the $actionName directory exists
                        is_dir(PATH_APP . self::getController()['name'] . DS . $actionName)
                    ) {

                        self::$action['name'] = $actionName;
                        self::$action['url']  = $actionLink;
                        self::$action['key']  = $actionKey;

                        if ($actionName == 'Index') {

                            self::$action['name'] = 'Index';
                            self::$action['url']  = '';
                            self::$action['key']  = 0;
                        } elseif ($actionName == 'View') {

                            self::$action['name'] = 'View';
                            self::$action['url']  = '';
                            self::$action['key']  = $actionKey;
                        }
                        #
                    } elseif ( // If such directory does not exist, but ActionName is not empty
                        iconv_strlen($actionName) > 0 &&
                        !is_dir(PATH_APP . self::getController()['name'] . DS . $actionName)
                    ) {

                        self::$action['name'] = 'View';
                        self::$action['url']  = '';
                        self::$action['key']  = $actionKey - 1;
                    }
                    #
                } elseif ( // If the key value is empty or does not exist
                    (isset(self::getUri()[$actionKey]) &&
                        iconv_strlen(self::getUri()[$actionKey]) === 0
                    ) ||
                    !isset(self::getUri()[$actionKey])
                ) {

                    self::$action['name'] = 'Index';
                    self::$action['url']  = '';
                    self::$action['key']  = 0;
                }
            }
        }

        return self::$action;
    }

    public static function getPageAlias()
    {
        if (self::$pageAlias === null) {

            if (
                self::getController()['name'] == 'Main' ||
                self::getAction()['name'] == 'Index'
            ) {

                self::$pageAlias = '';
                #
            } else {

                $pageKey = self::getAction()['key'] + 1;

                if (isset(self::getUri()[$pageKey])) {
                    $pageAlias       = self::getUri()[$pageKey];
                    $pageAlias       = explode(".", $pageAlias);
                    self::$pageAlias = $pageAlias[0];
                } else {
                    self::$pageAlias = '';
                }
            }
        }

        return self::$pageAlias;
    }
}
