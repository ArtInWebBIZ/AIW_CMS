<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'OV_CONTROL',
            'access'         => true,
            'controller_url' => 'search-bots-ip',
            'action_url'     => '',
            'page_alias'     => '',
        ],
        [
            'label'          => 'SBIP_ADD',
            'access'         => true,
            'controller_url' => 'search-bots-ip',
            'action_url'     => 'add',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_EDIT_HISTORY',
            'access'         => true,
            'controller_url' => 'search-bots-ip',
            'action_url'     => 'edit-history',
            'page_alias'     => '',
        ],
    ],
];
