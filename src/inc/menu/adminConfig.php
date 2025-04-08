<?php

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'OV_CONTROL',
            'access'         => true,
            'controller_url' => 'config-control',
            'action_url'     => 'control',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_EDIT_HISTORY',
            'access'         => true,
            'controller_url' => 'config-control',
            'action_url'     => 'edit-history',
            'page_alias'     => '',
        ],
        [
            'label'          => 'CONFIG_CONTROL_NEW',
            'access'         => GroupAccess::check([5]) ? true : false,
            'controller_url' => 'config-control',
            'action_url'     => 'add',
            'page_alias'     => '',
        ],
    ]
];
