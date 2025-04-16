<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Create\Menu;

defined('AIW_CMS') or die;

use Core\{Router, Trl, BaseUrl};

class Menu
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Menu
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Get html admin menu
     * @param array $params
     * @return string
     */
    public function createAdminMenu(array $params): string
    {
        if ($params['menu_access'] === true) {

            $titleMargin = isset($params['title_margin']) ? ' ' . $params['title_margin'] : '';

            $html = '';

            if ($params['menu_title'] != '') {
                $html .= '<h4 class="uk-text-center uk-margin-top uk-margin-small-bottom' . $titleMargin . '">' . Trl::_($params['menu_title']) . '</h4>';
                $html .= '<table itemscope itemtype="http://schema.org/SiteNavigationElement" class="uk-table-middle">';
            } else {
                $html .= '<table itemscope itemtype="http://schema.org/SiteNavigationElement" class="uk-table-middle uk-margin-small-top">';
            }

            $menuList = $params['menu_list'];

            foreach ($menuList as $key => $value) {

                if ($menuList[$key]['access'] === true) {

                    if (
                        $menuList[$key]['controller_url'] == Router::getRoute()['controller_url'] &&
                        $menuList[$key]['action_url'] == Router::getRoute()['action_url'] &&
                        $menuList[$key]['page_alias'] == Router::getRoute()['page_alias']
                    ) {

                        if (isset($menuList[$key]['icon'])) {
                            $iconLink = '<img src="' . $menuList[$key]['icon'] . '" alt="" class="icon-menu uk-margin-small-right" >';
                        } else {
                            $iconLink = '';
                        }

                        $html .= '
                        <tr>
                            <td>' . $iconLink . '</td>
                            <td class="color-orange">' . Trl::_($menuList[$key]['label']) . '</td>
                        </tr>';
                    } else {

                        $controlUrl = $menuList[$key]['controller_url'] != '' ? $menuList[$key]['controller_url'] . '/' : '';
                        $actionUrl  = $menuList[$key]['action_url'] != '' ? $menuList[$key]['action_url'] . '/' : '';
                        $pageAlias  = $menuList[$key]['page_alias'] != '' ? $menuList[$key]['page_alias'] . '.html' : '';

                        if (isset($menuList[$key]['icon'])) {
                            $iconLink = '
                                <a href="' . BaseUrl::getLangToLink() . $controlUrl . $actionUrl . $pageAlias . '">
                                    <img src="' . $menuList[$key]['icon'] . '" alt="" class="icon-menu uk-margin-small-right" >
                                </a>';
                        } else {
                            $iconLink = '';
                        }

                        $html .= '<tr>
                            <td>
                                ' . $iconLink . '
                            </td>
                            <td>
                                <a itemprop="url" class="menu-link" href="' . BaseUrl::getLangToLink() . $controlUrl . $actionUrl . $pageAlias . '">' . Trl::_($menuList[$key]['label']) . '</a>
                            </td>
                        </tr>';
                    }
                }
            }

            $html .= '</table>';

            return $html;
        } else {

            return '';
        }
    }
    /**
     * Get html main menu and user menu
     * @param array $params
     * @return string
     */
    public function createMenu(array $params): string
    {
        if ($params['menu_access'] === true) {

            $titleMargin = isset($params['title_margin']) ? ' ' . $params['title_margin'] : '';

            $html = '';

            if ($params['menu_title'] != '') {
                $html .= '<h4 class="uk-text-center uk-margin-top uk-margin-small-bottom' . $titleMargin . '">' . Trl::_($params['menu_title']) . '</h4>';
                $html .= '<table itemscope itemtype="http://schema.org/SiteNavigationElement" class="uk-table-middle">';
            } else {
                $html .= '<table itemscope itemtype="http://schema.org/SiteNavigationElement" class="uk-table-middle uk-margin-top">';
            }

            $menuList = $params['menu_list'];

            foreach ($menuList as $key => $value) {

                if ($menuList[$key]['access'] === true) {

                    if (
                        $menuList[$key]['controller_url'] == Router::getRoute()['controller_url'] &&
                        $menuList[$key]['action_url'] == Router::getRoute()['action_url'] &&
                        $menuList[$key]['page_alias'] == Router::getRoute()['page_alias']
                    ) {
                        $html .= '
                        <tr>
                            <td><img src="' . $menuList[$key]['icon'] . '" alt="" class="icon-menu uk-margin-small-right" ></td>
                            <td class="color-orange">' . Trl::_($menuList[$key]['label']) . '</td>
                        </tr>';
                    } else {

                        $controlUrl = $menuList[$key]['controller_url'] != '' ? $menuList[$key]['controller_url'] . '/' : '';
                        $actionUrl  = $menuList[$key]['action_url'] != '' ? $menuList[$key]['action_url'] . '/' : '';
                        $pageAlias  = $menuList[$key]['page_alias'] != '' ? $menuList[$key]['page_alias'] . '.html' : '';
                        $get        = isset($menuList[$key]['get']) && $menuList[$key]['get'] != '' ? '?' . $menuList[$key]['get'] : '';

                        $html .= '
                        <tr>
                            <td>
                                <a class="uk-text-decoration-none" href="' . BaseUrl::getLangToLink() . $controlUrl . $actionUrl . $pageAlias . $get . '">
                                    <img src="' . $menuList[$key]['icon'] . '" alt="" class="icon-menu uk-margin-small-right" >
                                </a>
                            </td>
                            <td>
                                <a itemprop="url" class="menu-link" href="' . BaseUrl::getLangToLink() . $controlUrl . $actionUrl . $pageAlias . $get . '">' . Trl::_($menuList[$key]['label']) . '</a>
                            </td>
                        </tr>';
                    }
                }
            }

            $html .= '</table>';

            return $html;
        } else {

            return '';
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
