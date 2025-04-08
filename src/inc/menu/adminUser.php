<?php
defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'USER_ADD',
            'access'         => GroupAccess::check([5]),
            'controller_url' => 'user',
            'action_url'     => 'new-user',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_CONTROL',
            'access'         => true,
            'controller_url' => 'user',
            'action_url'     => 'control',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_EDIT_HISTORY',
            'access'         => GroupAccess::check([4, 5]) ? true : false,
            'controller_url' => 'user',
            'action_url'     => 'edit-history',
            'page_alias'     => '',
        ],
    ]
];
