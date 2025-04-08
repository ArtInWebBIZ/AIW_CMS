<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Check\GroupAccess;

$groupAccess = GroupAccess::check([1, 2]);

return [
    'tpl'                 => $groupAccess ? 'index' : 'admin',
    'template'            => PATH_APP . 'User' . DS . 'MyEditHistory' . DS . 'inc' . DS . 'template.php',
    'title'               => 'OV_EDIT_HISTORY',
    'section_css'         => $groupAccess ? 'content-section' : 'uk-padding-remove-top',
    'item_heading'        => Auth::getUserFullName(),
    'access'              => Auth::getUserId() != 0 ? true : false,
    'content_type'        => 'user_edit_log',
    'page_link'           => 'user/my-edit-history/',
    'filters_clear_link'  => 'user/my-edit-history-clear/',
    'filter_fields'       => PATH_APP . 'User' . DS . 'MyEditHistory' . DS . 'inc' . DS . 'filters.php',
    'order_by'            => 'DESC',
    'control_header'      => PATH_APP . 'User' . DS . 'MyEditHistory' . DS . 'inc' . DS . 'header.php',
    'control_body'        => PATH_APP . 'User' . DS . 'MyEditHistory' . DS . 'inc' . DS . 'body.php',
    'fields_in_body'      => ['id', 'editor_id', 'edited_field', 'old_value', 'new_value', 'edited'],
    'filter_button_label' => 'LABEL_SELECT',
    'extra'               => [
        'edited_id' => [
            'filters_values' => Auth::getUserId(),
            'sql'            => '`edited_id` = :edited_id AND ',
        ],
    ],
];
