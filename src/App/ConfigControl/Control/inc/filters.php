<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Select\Order\OrderOption;
use Core\Trl;

return [
    'id'       => [
        'label'       => Trl::_('CONFIG_PARAMETER_ID'),
        'name'        => 'id',
        'type'        => 'text',
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
    'order_by' => [
        'label'       => Trl::_('ORDER_BY'),
        'name'        => 'order_by',
        'type'        => 'select',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => false,
        'check'       => OrderOption::getI()->clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['order_by']) ? OrderOption::getI()->option($v['order_by']) : OrderOption::getI()->option(),
        'info'        => '',
    ],
];
