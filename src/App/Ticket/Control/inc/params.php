<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\Ticket\Control\Req\Func;
use Core\Plugins\Dll\ForAll;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'TICKET_CONTROL',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'ticket',
        'page_link'           => 'ticket/control/',
        'filters_clear_link'  => 'ticket/control-clear/',
        'filter_fields'       => ForAll::contIncPath() . 'fields.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'order_by'            => 'ASC',
        'fields_in_body'      => ['id', 'responsible', 'created', 'edited', 'editor_id', 'ticket_status'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => Func::getI()->extra(),
    ];
