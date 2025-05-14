<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\ConfigControl\Select;
use Core\{Auth, Config, Trl};

$addFields = require PATH_APP . 'ConfigControl' . DS . 'Add' . DS . 'inc' . DS . 'fields.php';

return [
    'id'           => [
        'label'       => Trl::_('CONFIG_PARAMETER_ID'),
        'name'        => 'id',
        'type'        => 'text',
        'clean'       => 'unsInt',
        'disabled'    => true,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['id']) ? $v['id'] : '',
        'info'        => '',
    ],
    'params_name'  => $addFields['params_name'],
    'params_value' => $addFields['params_value'],
    'value_type'   => [
        'label'       => Trl::_('CONFIG_VALUE_TYPE'),
        'name'        => 'value_type',
        'type'        => 'select',
        'clean'       => 'str',
        'disabled'    => true,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_FILTER_NAME_LEN'),
        'maxlength'   => Config::getCfg('CFG_USER_PHONE_LEN'),
        'check'       => Select::clear(),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['value_type']) ? Select::option((string) $v['value_type']) : Select::option(),
        'info'        => '',
    ],
    'group_access' => Auth::getUserGroup() == 5 ? $addFields['group_access'] : null,
];
