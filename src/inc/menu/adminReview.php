<?php

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'REVIEW_ADD',
            'access'         => true,
            'controller_url' => 'review',
            'action_url'     => 'add',
            'page_alias'     => '',
        ],
        [
            'label'          => 'REVIEW_MY_REVIEWS',
            'access'         => true,
            'controller_url' => 'review',
            'action_url'     => 'my',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_CONTROL',
            'access'         => GroupAccess::check([2, 5]),
            'controller_url' => 'review',
            'action_url'     => 'control',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_EDIT_HISTORY',
            'access'         => true,
            'controller_url' => 'review',
            'action_url'     => 'edit-history',
            'page_alias'     => '',
        ],
    ]
];
