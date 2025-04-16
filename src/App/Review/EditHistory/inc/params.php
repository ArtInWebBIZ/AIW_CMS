<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\Review\EditHistory\Req\Func;
use Core\Plugins\Dll\ForAll;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'REVIEW_EDIT_HISTORY',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'review_edit_log',
        'page_link'           => 'review/edit-history/',
        'filters_clear_link'  => 'review/edit-history-clear/',
        'order_by'            => 'DESC',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'fields_in_body'      => ['id', 'edited_id', 'editor_id', 'edited_field', 'old_value', 'new_value', 'edited'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => Func::getI()->extra(),
    ];
