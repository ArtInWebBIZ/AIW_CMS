<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Select\Ticket\StatusOption;
use Core\Trl;

return [
    'id'            => [
        'label'       => '',
        'name'        => 'id',
        'type'        => 'hidden',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['id']) ? $v['id'] : '',
        'info'        => '',
    ],
    'ticket_status' => [
        'label'       => Trl::_('TICKET_STATUS'),
        'name'        => 'ticket_status',
        'type'        => 'select',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => true,
        'check'       => StatusOption::getI()->clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => StatusOption::getI()->option(),
        'info'        => Trl::_('OV_REQUIRED_FIELD'),
    ],
];
