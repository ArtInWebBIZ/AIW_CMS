<?php

use Core\{Auth, Session};

defined('AIW_CMS') or die;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'USER_RESET_PASSWORD',
            'access'         => true,
            'controller_url' => 'user',
            'action_url'     => 'pass-reset',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/people-search.svg',
        ],
        [
            'label'          => 'USER_ADD',
            'access'         => Auth::getUserId() == 0 && Session::getTmpStatus() == -1 ? true : false,
            'controller_url' => 'user',
            'action_url'     => 'add',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/people-plus.svg',
        ],
    ],
];
