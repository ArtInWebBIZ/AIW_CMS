<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\User\EditHistory\Req\Func;
use Core\Plugins\Check\GroupAccess;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'USER_EDIT_HISTORY_USERS',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'user_edit_log',
        'page_link'           => 'user/edit-history/',
        'filters_clear_link'  => 'user/edit-history-clear/',
        'filter_fields'       => PATH_APP . 'User' . DS . 'EditHistory' . DS . 'inc' . DS . 'filters.php',
        'order_by'            => 'DESC',
        'control_header'      => PATH_APP . 'User' . DS . 'EditHistory' . DS . 'inc' . DS . 'header.php',
        'control_body'        => PATH_APP . 'User' . DS . 'EditHistory' . DS . 'inc' . DS . 'body.php',
        'fields_in_body'      => ['id', 'edited_id', 'editor_id', 'edited_field', 'old_value', 'new_value', 'edited'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => GroupAccess::check([1, 2, 3, 4]) ? [
            'edited_id' => [
                'sql'            => '`edited_id` NOT IN (' . Func::getI()->closedUser()['sql'] . ') AND ',
                'filters_values' => Func::getI()->closedUser()['array'],
            ],
        ] : [],
    ];
