<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Pick;

defined('AIW_CMS') or die;

use Core\Clean;
use Core\GV;
use Core\Plugins\Ssl;

class FromHttpReferer
{
    private static $fullLink       = '';
    private static $baseLink       = '';
    private static $pageAlias      = '';
    private static $pageAliasKey   = '';
    private static $controllerName = '';
    private static $actionName     = null;
    private static $linkToArray    = [];

    public static function getFullLink()
    {
        if (self::$fullLink == '') {
            self::$fullLink = Clean::url(GV::server()['HTTP_REFERER']);
        }

        return self::$fullLink;
    }

    public static function getBaseLink()
    {
        if (self::$baseLink == '') {
            $baseLink       = explode("?", self::getFullLink());
            self::$baseLink = $baseLink[0];
        }

        return self::$baseLink;
    }

    private static function linkToArray()
    {
        if (self::$linkToArray == []) {

            $linkToArray = trim(str_ireplace([Ssl::getLink()], '', self::getBaseLink()));

            $linkToArray = explode("/", $linkToArray);

            /**
             * Удаляем пустые значения массива
             */
            foreach ($linkToArray as $key => $value) {
                if ($linkToArray[$key] == '') {
                    unset($linkToArray[$key]);
                }
            }

            $linkToArray = implode("/", $linkToArray);
            $linkToArray = explode("/", $linkToArray);

            self::$linkToArray = $linkToArray;
        }

        return self::$linkToArray;
    }

    private static function getPageAliasKey()
    {
        if (self::$pageAliasKey == '') {

            $linkToArray = self::linkToArray();

            $pageAliasKey = '';

            foreach ($linkToArray as $key => $value) {
                if (stripos($linkToArray[$key], '.html')) {
                    $pageAliasKey = $key;
                }
            }

            self::$pageAliasKey = $pageAliasKey == '' ? null : (int) $pageAliasKey;
        }

        return self::$pageAliasKey;
    }

    public static function getPageAlias()
    {
        if (self::$pageAlias == '') {

            if (self::getPageAliasKey() !== null) {

                $alias = self::linkToArray()[self::getPageAliasKey()];

                $alias           = explode('.', $alias);
                self::$pageAlias = $alias[0];
            } else {
                self::$pageAlias = null;
            }
        }

        return self::$pageAlias;
    }

    public static function getControllerName()
    {
        if (self::$controllerName == '') {

            $controllerName = '';

            if (stripos(self::linkToArray()[1], '.html') === false) {
                $controllerName = self::linkToArray()[1];
            }

            if ($controllerName == '') {
                $controllerName = 'Main';
            }

            self::$controllerName = $controllerName;
        }

        return self::$controllerName;
    }

    public static function getActionName()
    {
        if (self::$actionName === null) {
            if (
                self::getPageAliasKey() > 2 &&
                self::getControllerName() != 'Main'
            ) {
                self::$actionName = self::linkToArray()[2];
            } elseif (
                self::getPageAliasKey() == 2 &&
                self::getControllerName() != 'Main'
            ) {
                self::$actionName = 'view';
            } elseif (
                self::getPageAliasKey() !== null &&
                self::getControllerName() == 'Main'
            ) {
                self::$actionName = 'view';
            } elseif (
                self::getPageAliasKey() === null &&
                self::getControllerName() == 'Main'
            ) {
                self::$actionName = 'index';
            }
        }

        return self::$actionName;
    }
}
