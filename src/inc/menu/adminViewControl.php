<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

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
    ],
];
