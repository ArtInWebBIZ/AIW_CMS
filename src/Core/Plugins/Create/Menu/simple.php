<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Create\Menu\Menu;

Menu::getI()->createMenu(
    [
        'menu_access' => 'access_params' ? true : false, // REQUIRED
        'menu_title'  => 'TITLE_KEY', // or ''
        'menu_list'   => [
            'MENU_TRL_KEY' => [
                'access'         => 'access_params' ? true : false, // REQUIRED
                'controller_url' => 'router_controller_url', // or ''
                'action_url'     => 'router_action_url', // or ''
                'page_alias'     => '', // or 'page_alias_value'
            ],
        ],
    ]
);
