<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\Ticket\EditHistory\Req\Func;
use Core\Plugins\Dll\ForAll;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'TICKET_TICKETS_EDIT_HISTORY',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'ticket_edit_log',
        'page_link'           => 'ticket/edit-history/',
        'filters_clear_link'  => 'ticket/edit-history-clear/',
        'filter_fields'       => ForAll::contIncPath() . 'fields.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'order_by'            => 'DESC',
        'fields_in_body'      => ['id', 'ticket_id', 'ticket_type', 'editor_id', 'edited_field', 'old_value', 'new_value', 'edited'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => Func::getI()->extra(),
    ];
