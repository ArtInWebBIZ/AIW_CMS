<?php

defined('AIW_CMS') or die;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'BLOG_ADD',
            'access'         => true,
            'controller_url' => 'blog',
            'action_url'     => 'add',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_CONTROL',
            'access'         => true,
            'controller_url' => 'blog',
            'action_url'     => 'control',
            'page_alias'     => '',
        ],
        [
            'label'          => 'OV_EDIT_HISTORY',
            'access'         => true,
            'controller_url' => 'blog',
            'action_url'     => 'edit-history',
            'page_alias'     => '',
        ],
    ]
];
