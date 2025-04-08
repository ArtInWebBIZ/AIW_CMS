<?php

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Check\GroupAccess;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'OV_CONTROL',
            'access'         => GroupAccess::check([2, 5]),
            'controller_url' => 'ticket',
            'action_url'     => 'control',
            'page_alias'     => '',
        ],
        [
            'label'          => 'TICKET_MY_TICKETS',
            'access'         => true,
            'controller_url' => 'ticket',
            'action_url'     => 'my',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_EDIT_HISTORY',
            'access'         => true,
            'controller_url' => 'ticket',
            'action_url'     => 'edit-history',
            'page_alias'     => '',
        ],
    ]
];
