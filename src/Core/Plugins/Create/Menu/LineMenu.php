<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Create\Menu;

defined('AIW_CMS') or die;

use Core\{BaseUrl, Router, Trl};
use Core\Plugins\View\Tpl;

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
    /**
     * Get menu html for top line menu
     * @param array $params
     * @return string
     */
    public function createMenu(array $params): string
    {
        if ($params !== []) {

            $html = '';

            $html .= Tpl::view(PATH_TPL . 'menu' . DS . 'line' . DS . 'header.php');

            foreach ($params as $key => $value) {

                if ($params[$key]['menu_access'] === true) {
                    /**
                     * If key ['menu_list'] is empty array
                     */
                    if ($params[$key]['menu_list'] === []) {
                        /**
                         * View li
                         */
                        $html .= $this->li($params[$key]);
                        #
                    } else {
                        /**
                         * View parent
                         */
                        $html .= $this->parent($params[$key]);
                        #
                    }
                }
            }
            unset($key, $value);

            $html .= Tpl::view(PATH_TPL . 'menu' . DS . 'line' . DS . 'footer.php');

            return $html;
            #
        } else {
            return '';
        }
    }

    private function li(array $params): string
    {
        /**
         * Check active link
         */
        if (
            (
                $params['action_url'] == '' &&
                $params['page_alias'] == '' &&
                $params['controller_url'] == Router::getRoute()['controller_url']
            ) ||
            (
                $params['action_url'] !== '' &&
                $params['page_alias'] == '' &&
                $params['controller_url'] == Router::getRoute()['controller_url'] &&
                $params['action_url'] == Router::getRoute()['action_url']
            ) ||
            (
                $params['page_alias'] !== '' &&
                $params['controller_url'] == Router::getRoute()['controller_url'] &&
                $params['action_url'] == Router::getRoute()['action_url'] &&
                $params['page_alias'] == Router::getRoute()['page_alias']
            )
        ) {
            $activeLink = 'uk-active';
        } else {
            $activeLink = 'uk-text-primary';
        }
        /**
         * Prepare link
         */
        $link = BaseUrl::getLangToLink();

        $link .= $params['controller_url'] != '' ? $params['controller_url'] . '/' : '';
        $link .= $params['action_url'] != '' ? $params['action_url'] . '/' : '';
        $link .= $params['page_alias'] != '' ? $params['page_alias'] . '.html' : '';

        return Tpl::view(
            PATH_TPL . 'menu' . DS . 'line' . DS . 'li.php',
            [
                'active'     => $activeLink,
                'link'       => $link,
                'menu_title' => Trl::_($params['menu_title']),
            ]
        );
    }

    private function parent(array $params): string
    {
        /**
         * Check active link
         */
        if (
            $params['controller_url'] == Router::getRoute()['controller_url']
        ) {
            $activeLink = 'uk-active';
        } else {
            $activeLink = 'uk-text-primary';
        }
        /**
         * Prepare li
         */
        $li = '';

        foreach ($params['menu_list'] as $key => $value) {
            $li .= $this->li($value);
        }
        unset($key, $value);

        return Tpl::view(
            PATH_TPL . 'menu' . DS . 'line' . DS . 'parent.php',
            [
                'active'      => $activeLink,
                'parent_name' => Trl::_($params['menu_title']),
                'li'          => $li,
            ]
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
