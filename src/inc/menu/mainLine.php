<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;

return [
    [
        'menu_access'    => true,
        'menu_title'     => 'OV_HOME',
        'controller_url' => '',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ],
    [
        'menu_access'    => true,
        'menu_title'     => 'DOC_ABOUT_US',
        'controller_url' => 'doc',
        'action_url'     => '',
        'page_alias'     => 'about-us',
        #
        'menu_list'   => [],
    ],
    [
        'menu_access'    => true,
        'menu_title'     => 'REVIEW_REVIEWS',
        'controller_url' => 'review',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ],
    [
        'menu_access'    => true,
        'menu_title'     => 'BLOG_BLOG',
        'controller_url' => 'blog',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ],
    [
        'menu_access'    => true,
        'menu_title'     => 'OV_CONTACTS',
        'controller_url' => 'contacts',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ],
    [
        'menu_access'    => GroupAccess::check([5]),
        'menu_title'     => 'ADMIN_ADMIN',
        'controller_url' => 'admin',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [
            [
                'menu_access'    => true,
                'menu_title'     => 'ADMIN_COMPARE_LANG_FILES',
                'controller_url' => 'admin',
                'action_url'     => 'compare-lang-files',
                'page_alias'     => '',
            ],
            [
                'menu_access'    => true,
                'menu_title'     => 'ADMIN_FIND_UNIQUE_SYMBOLS',
                'controller_url' => 'admin',
                'action_url'     => 'find-unique-symbols',
                'page_alias'     => '',
            ],
            [
                'menu_access'    => true,
                'menu_title'     => 'ADMIN_CLEAN_HTML',
                'controller_url' => 'admin',
                'action_url'     => 'clean-html',
                'page_alias'     => '',
            ],
        ],
    ]
];
