<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\Ticket\Lib\Select\Type;
use Core\{Config, Trl};

return [
    'ticket_type' => [
        'label'       => Trl::_('TICKET_TYPE'),
        'name'        => 'ticket_type',
        'type'        => 'select',
        'clean'       => 'unsInt',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => 1,
        'maxlength'   => 1,
        'check'       => Type::getI()->toContactsClear(),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['ticket_type']) ?
            Type::getI()->toContactsOption((int) $v['ticket_type']) :
            Type::getI()->toContactsOption(),
        'info'        => '',
    ],
    'text'        => [
        'label'       => Trl::_('CONTACTS_TEXT'),
        'name'        => 'text',
        'type'        => 'textarea',
        'clean'       => 'text',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_TICKET_ANSWER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_TICKET_ANSWER_LEN'),
        'class'       => 'uk-textarea',
        'rows'        => Config::getCfg('CFG_TEXTAREA_ROWS'),
        'placeholder' => '',
        'value'       => '',
        'info'        => '',
    ],
];
