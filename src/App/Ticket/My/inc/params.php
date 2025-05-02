<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\Ticket\My\Req\Func;
use Core\Auth;
use Core\Plugins\Lib\ForAll;

return
    [
        'title'               => 'TICKET_CONTROL',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'ticket',
        'page_link'           => 'ticket/my/',
        'filters_clear_link'  => 'ticket/my-clear/',
        'filter_fields'       => ForAll::contIncPath() . 'fields.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'order_by'            => 'DESC',
        'fields_in_body'      => ['id', 'responsible', 'created', 'edited', 'editor_id', 'ticket_status'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [
            'author_id' => [
                'sql'            => '`author_id` = :author_id AND ',
                'filters_values' => Auth::getUserId(),
            ],
        ],
    ];
