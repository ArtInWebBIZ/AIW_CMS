<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\User\Lib\Select\{Group, Status};
use Core\Config;
use Core\Plugins\Fields\Filters;
use Core\Trl;

return [
    'id'           => [
        'label'       => Trl::_('USER_ID'),
        'name'        => 'id',
        'type'        => 'text',
        'clean'       => 'unsInt',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['id']) ? $v['id'] : '',
        'info'        => '',
    ],
    'group'        => [
        'label'       => Trl::_('USER_GROUP'),
        'name'        => 'group',
        'type'        => 'select',
        'clean'       => 'unsInt',
        'disabled'    => false,
        'required'    => false,
        'check'       => Group::getI()->clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['group']) ? Group::getI()->option((int) $v['group']) : Group::getI()->option(),
        'info'        => '',
    ],
    'created_from' => Filters::getI()->createdFrom(isset($v['created_from']) ? $v['created_from'] : ''),
    'created_to'   => Filters::getI()->createdTo(isset($v['created_to']) ? $v['created_to'] : ''),
    'edited_from'  => Filters::getI()->editedFrom(isset($v['edited_from']) ? $v['edited_from'] : ''),
    'edited_to'    => Filters::getI()->editedTo(isset($v['edited_to']) ? $v['edited_to'] : ''),
    'status'       => [
        'label'       => Trl::_('USER_STATUS'),
        'name'        => 'status',
        'type'        => 'select',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'check'       => Status::getI()->clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['status']) ? Status::getI()->option((int) $v['status']) : Status::getI()->option(),
        'info'        => '',
    ],
    'order_by'        => Filters::getI()->order(isset($v['order_by']) ? $v['order_by'] : ''),
];
