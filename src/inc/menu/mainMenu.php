<?php

defined('AIW_CMS') or die;

return [
    'menu_access' => true,
    'menu_title'  => '',
    'menu_list'   => [
        [
            'label'          => 'OV_HOME',
            'access'         => true,
            'controller_url' => '',
            'action_url'     => '',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/home.svg',
        ],
        [
            'label'          => 'DOC_ABOUT_US',
            'access'         => true,
            'controller_url' => 'doc',
            'action_url'     => '',
            'page_alias'     => 'about-us',
            'icon'           => '/img/icons-menu/editor.svg',
        ],
        [
            'label'          => 'EXCURSION_EXCURSIONS',
            'access'         => true,
            'controller_url' => 'excursion',
            'action_url'     => '',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/guide-board.svg',
        ],
        [
            'label'          => 'SERVICE_SERVICE',
            'access'         => true,
            'controller_url' => 'service',
            'action_url'     => '',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/airplane.svg',
        ],
        [
            'label'          => 'REVIEW_REVIEWS',
            'access'         => true,
            'controller_url' => 'review',
            'action_url'     => '',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/notebook-and-pen.svg',
        ],
        [
            'label'          => 'BLOG_BLOG',
            'access'         => true,
            'controller_url' => 'blog',
            'action_url'     => '',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/book-open.svg',
        ],
        [
            'label'          => 'OV_CONTACTS',
            'access'         => true,
            'controller_url' => 'contacts',
            'action_url'     => '',
            'page_alias'     => '',
            'icon'           => '/img/icons-menu/id-card-h.svg',
        ],
    ],
];
