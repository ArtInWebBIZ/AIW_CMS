<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Select\Order;
use Core\Trl;

return [
    /**
     * Get field config_control ID
     */
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
    /**
     * Get field order_by
     */
    'order_by' => [
        'label'       => Trl::_('ORDER_BY'),
        'name'        => 'order_by',
        'type'        => 'select',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => false,
        'check'       => Order::clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['order_by']) ? Order::option((string) $v['order_by']) : Order::option(),
        'info'        => '',
    ],
];
