<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Lib\ForAll;

$groupAccess = GroupAccess::check([1, 2]);

return [
    'tpl'                 => $groupAccess ? 'index' : 'admin',
    'template'            => ForAll::contIncPath() . 'template.php',
    'title'               => 'OV_EDIT_HISTORY',
    'section_css'         => $groupAccess ? 'content-section' : 'uk-padding-remove-top',
    'item_heading'        => Auth::getUserFullName(),
    'access'              => Auth::getUserId() != 0 ? true : false,
    'content_type'        => 'user_edit_log',
    'page_link'           => 'user/my-edit-history/',
    'filters_clear_link'  => 'user/my-edit-history-clear/',
    'order_by'            => 'DESC',
    'filter_fields'       => ForAll::contIncPath() . 'filters.php',
    'control_header'      => ForAll::contIncPath() . 'header.php',
    'control_body'        => ForAll::contIncPath() . 'body.php',
    'fields_in_body'      => ['id', 'editor_id', 'edited_field', 'old_value', 'new_value', 'edited'],
    'filter_button_label' => 'LABEL_SELECT',
    'extra'               => [
        'edited_id' => [
            'sql'            => '`edited_id` = :edited_id AND ',
            'filters_values' => Auth::getUserId(),
        ],
    ],
];
