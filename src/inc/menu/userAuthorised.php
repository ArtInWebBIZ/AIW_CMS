<?php

defined('AIW_CMS') or die;

use Core\{Auth, BaseUrl, Plugins\Ssl};

return [
    'menu_access'  => true,
    'title_margin' => 'uk-margin-top',
    'menu_title'   => Auth::getUserFullName(),
    'menu_list'    => [
        [
            'label'          => 'USER_PROFILE',
            'access'         => Auth::getUserStatus() > 0 ? true : false,
            'controller_url' => 'user',
            'action_url'     => '',
            'page_alias'     => Auth::getUserId(),
            'icon'           => '/img/icons-menu/id-card-v.svg',
        ],
        [
            'label'          => 'USER_EDIT_PROFILE',
            'access'         => Auth::getUserStatus() == 1 ? true : false,
            'controller_url' => 'user',
            'action_url'     => 'edit',
            'page_alias'     => Auth::getUserId(),
            'icon'           => '/img/icons-menu/edit-name.svg',
        ],
        [
            'label'          => 'OV_EDIT_HISTORY',
            'access'         => Auth::getUserStatus() == 1 ? true : false,
            'controller_url' => 'user',
            'action_url'     => 'my-edit-history',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/peoples.svg',
        ],
        [
            'label'          => 'USER_CHANGE_PASSWORD',
            'access'         => Auth::getUserStatus() == 1 ? true : false,
            'controller_url' => 'user',
            'action_url'     => 'change-pass',
            'page_alias'     => Auth::getUserId(),
            'icon'           => '/img/icons-menu/passport.svg',
        ],
        [
            'label'          => 'USER_LOGOUT',
            'access'         => true,
            'controller_url' => 'user',
            'action_url'     => 'logout',
            'page_alias'     => '',
            'get'            => 'referer=' . Ssl::getLink() . BaseUrl::getFullUrl(),
            'icon'           => '/img/icons-menu/logout.svg',
        ],
    ],
];
