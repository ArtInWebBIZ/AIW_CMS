<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Create\Menu;

defined('AIW_CMS') or die;

use Core\{Router, Trl, BaseUrl, Clean};
use Core\Plugins\Ssl;

class LineMenu
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): LineMenu
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function createMenu(array $params)
    {
        if ($params['menu_access'] === true) {

            $html = '';

            if ($params['menu_list'] == []) {

                if (
                    $params['controller_url'] == Clean::str(Router::getRoute()['controller_url'])
                ) {
                    $activeLink = 'uk-active';
                } else {
                    $activeLink = 'uk-text-primary';
                }

                $link = '';

                $link .= $params['controller_url'] != '' ? $params['controller_url'] . '/' : '';
                $link .= $params['action_url'] != '' ? $params['action_url'] . '/' : '';
                $link .= $params['page_alias'] != '' ? $params['page_alias'] . '.html' : '';

                $html .= '
                <div class="uk-inline">
                    <a class="uk-button uk-button-link ' . $activeLink . '" href="' . Ssl::getLinkLang() . $link . '">' . Trl::_($params['menu_title']) . '</a>
                </div>';
                #
            } else {

                $html .= '
                <div class="uk-inline">
                    <button class="uk-button uk-button-link uk-text-primary" type="button">' . Trl::_($params['menu_title']) . '</button>
                    <div uk-dropdown="mode: click">
                       <ul class="uk-nav uk-dropdown-nav uk-text-uppercase">';

                $menuList = $params['menu_list'];

                foreach ($menuList as $key => $value) {

                    if ($menuList[$key]['access'] === true) {

                        if (
                            $menuList[$key]['controller_url'] == Clean::str(Router::getRoute()['controller_url']) &&
                            $menuList[$key]['action_url']     == Clean::str(Router::getRoute()['action_url']) &&
                            $menuList[$key]['page_alias']     == Clean::str(Router::getRoute()['page_alias'])
                        ) {

                            $html .= '<li><a href="#" class="uk-active">' . Trl::_($key) . '</a></li>';
                            #
                        } else {

                            $controlUrl = $menuList[$key]['controller_url'] != '' ? $menuList[$key]['controller_url'] . '/' : '';
                            $actionUrl  = $menuList[$key]['action_url'] != '' ? $menuList[$key]['action_url'] . '/' : '';
                            $pageAlias  = $menuList[$key]['page_alias'] != '' ? $menuList[$key]['page_alias'] . '.html' : '';

                            $html .= '
                                <li><a href="' . Ssl::getLinkLang() . $controlUrl . $actionUrl . $pageAlias . '">' . Trl::_($key) . '</a></li>';
                        }
                    }
                }

                $html .= '</ul></div></div>';
            }


            return $html;
            #
        } else {
            return '';
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
