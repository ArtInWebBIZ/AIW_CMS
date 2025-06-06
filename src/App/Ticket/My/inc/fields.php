<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\Ticket\Lib\Select\Status;
use Core\Plugins\Fields\Filters;
use Core\Trl;

return [
    'responsible'   => [
        'label'       => Trl::_('TICKET_RESPONSIBLE_ID'),
        'name'        => 'responsible',
        'type'        => 'text',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => 1,
        'maxlength'   => 10,
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['responsible']) ? $v['responsible'] : '',
        'info'        => '',
    ],
    'editor_id'     => [
        'label'       => Trl::_('LABEL_EDITOR_ID'),
        'name'        => 'editor_id',
        'type'        => 'text',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => 1,
        'maxlength'   => 10,
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['editor_id']) ? $v['editor_id'] : '',
        'info'        => '',
    ],
    'created_from' => Filters::getI()->createdFrom(isset($v['created_from']) ? $v['created_from'] : ''),
    'created_to'   => Filters::getI()->createdTo(isset($v['created_to']) ? $v['created_to'] : ''),
    'edited_from'  => Filters::getI()->editedFrom(isset($v['edited_from']) ? $v['edited_from'] : ''),
    'edited_to'    => Filters::getI()->editedTo(isset($v['edited_to']) ? $v['edited_to'] : ''),
    'ticket_status' => [
        'label'       => Trl::_('TICKET_STATUS'),
        'name'        => 'ticket_status',
        'type'        => 'select',
        'clean'       => 'unsInt',
        'disabled'    => false,
        'required'    => false,
        'check'       => Status::getI()->clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['ticket_status']) ? Status::getI()->option((int) $v['ticket_status']) : Status::getI()->option(),
        'info'        => '',
    ],
];
