<?php

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'OV_ATTENDANCE',
            'access'         => true,
            'controller_url' => 'view-log',
            'action_url'     => 'control',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_ATTENDANCE_MANAGERS',
            'access'         => true,
            'controller_url' => 'view-log',
            'action_url'     => 'control-managers',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_ATTENDANCE_INDEX',
            'access'         => true,
            'controller_url' => 'view-log',
            'action_url'     => 'control-index',
            'page_alias'     => '',
        ],
        [
            'label'          => 'ITEM_CONTROLLER_URL',
            'access'         => GroupAccess::check([5]),
            'controller_url' => 'item-controller',
            'action_url'     => '',
            'page_alias'     => '',
        ],
        [
            'label'          => 'SBIP_CONTROL',
            'access'         => GroupAccess::check([5]),
            'controller_url' => 'search-bots-ip',
            'action_url'     => '',
            'page_alias'     => '',
        ],
        [
            'label'          => 'SBIP_ADD',
            'access'         => GroupAccess::check([5]),
            'controller_url' => 'search-bots-ip',
            'action_url'     => 'add',
            'page_alias'     => '',
        ],
    ],
];
