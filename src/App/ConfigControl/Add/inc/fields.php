<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\ConfigControl\Select;
use Core\Config;
use Core\Trl;

return [
    'params_name'  => [
        'label'       => Trl::_('CONFIG_PARAMETER'),
        'name'        => 'params_name',
        'type'        => 'text',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_NAME_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_NAME_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['params_name']) ? $v['params_name'] : '',
        'info'        => '',
    ],
    'params_value' => [
        'label'       => Trl::_('CONFIG_PARAMETER_VALUE'),
        'name'        => 'params_value',
        'type'        => 'text',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_FILTER_NAME_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['params_value']) ? $v['params_value'] : '',
        'info'        => '',
    ],
    'value_type'   => [
        'label'       => Trl::_('CONFIG_VALUE_TYPE'),
        'name'        => 'value_type',
        'type'        => 'select',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_FILTER_NAME_LEN'),
        'maxlength'   => Config::getCfg('CFG_USER_PHONE_LEN'),
        'check'       => Select::clear(),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['value_type']) ? Select::option($v['value_type']) : Select::option(),
        'info'        => '',
    ],
    'group_access' => [
        'label'       => Trl::_('CONFIG_GROUP_ACCESS'),
        'name'        => 'group_access',
        'type'        => 'text',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MIN_NAME_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['group_access']) ? $v['group_access'] : '',
        'info'        => '',
    ],
];
