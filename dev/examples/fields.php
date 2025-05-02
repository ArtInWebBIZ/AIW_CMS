<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\User\Lib\Select\Status;
use Core\Config;
use Core\Plugins\Lib\ForAll;
use Core\Trl;

return [
    'text_field'     => [ // VALUE IS EXAMPLE TEXT FIELD !!! CHANGE_THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'name'        => 'text_field', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'type'        => 'text', // !!! NOT !!! CHANGE_THIS !!!
        'clean'       => 'str', // or 'int', 'unsInt', 'float'
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => Config::getCfg('MIN_EXAMPLE_LEN'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'maxlength'   => Config::getCfg('MAX_EXAMPLE_LEN'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'class'       => 'uk-input', // !!! NOT !!! CHANGE_THIS !!!
        'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('FIELD_NAME_EXAMPLE'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'value'       => isset($v['text_field']) ? $v['text_field'] : '', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::sprintf('FIELD_NAME_INFO', ...[ // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
            Config::getCfg('MIN_EXAMPLE_LEN'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
            Config::getCfg('MAX_EXAMPLE_LEN'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        ]), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
    ],
    'link_field'     => [ // VALUE IS EXAMPLE LINK FIELD !!! CHANGE_THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'name'        => 'link_field', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'type'        => 'text', // !!! NOT !!! CHANGE_THIS !!!
        'clean'       => 'link', // !!! NOT !!! CHANGE_THIS !!!
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => Config::getCfg('CFG_MIN_LINK_LEN'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'maxlength'   => Config::getCfg('CFG_MAX_LINK_LEN'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'class'       => 'uk-input', // !!! NOT !!! CHANGE_THIS !!!
        'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('EXAMPLE_SOC_NET_PAGE'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'value'       => isset($v['link_field']) ? $v['link_field'] : '', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::sprintf('FIELD_SOC_NET_PAGE_ERROR', ...[ // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
            Config::getCfg('CFG_MIN_LINK_LEN'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
            Config::getCfg('CFG_MAX_LINK_LEN'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        ]), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
    ],
    'file_field'     => [ // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE_THIS !!!
        'label'         => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'name'          => 'file_field', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'type'          => 'file', // !!! NOT !!! CHANGE_THIS !!!
        'clean'         => '', // !!! NOT !!! CHANGE_THIS !!!
        'disabled'      => false, // true or false
        'required'      => true, // true or false
        'MAX_file_size' => Config::getCfg('MAX_FILE_SIZE'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'allow_file_type' => ['jpg', 'jpeg', 'jpe'], // VALUE IS EXAMPLE !!!
        'deny_file_type'  => ['exe', 'bat', 'ini', 'iso'], // VALUE IS EXAMPLE !!!
        'class'         => 'uk-input', // !!! NOT !!! CHANGE_THIS !!!
        'placeholder'   => Trl::_('OV_FILE_SELECT'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'value'         => is_array($v['file_field']) ? $v['file_field'] : '',
        'info'          => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('FIELD_NAME_INFO'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
    ],
    'multiple_field'   => [ // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE_THIS !!!
        'label'         => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE_THIS !!!
        'name'          => 'multiple_field', // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE_THIS !!!
        'type'          => 'multiple', // !!! NOT !!! CHANGE_THIS !!!
        'clean'         => '', // !!! NOT !!! CHANGE_THIS !!!
        'disabled'      => false, // true or false
        'required'      => true, // true or false
        'MAX_file_size' => Config::getCfg('MAX_IMAGES_SIZE'), // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE_THIS !!!
        'allow_file_type' => ['jpg', 'jpeg', 'jpe'], // VALUE IS EXAMPLE !!!
        'deny_file_type'  => ['exe', 'bat', 'ini', 'iso'], // VALUE IS EXAMPLE !!!
        'class'         => 'uk-input', // !!! NOT !!! CHANGE_THIS !!!
        'placeholder'   => Trl::_('OV_FILE_SELECT'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'value'         => is_array($v['file_field']) ? $v['file_field'] : '',
        'info'          => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('FIELD_NAME_INFO'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
    ],
    'hidden_field'   => [ // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'label'       => '', // !!! NOT !!! CHANGE_THIS !!!
        'name'        => 'hidden_field', // !!! NOT !!! CHANGE_THIS !!!
        'type'        => 'hidden', // !!! NOT !!! CHANGE_THIS !!!
        'clean'       => 'str', // !!! NOT !!! CHANGE_THIS !!!
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => 32, // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'maxlength'   => 32, // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'class'       => '', // !!! NOT !!! CHANGE_THIS !!!
        'placeholder' => '', // !!! NOT !!! CHANGE_THIS !!!
        'value'       => isset($v['hidden_field']) ? $v['hidden_field'] : '', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'info'        => '', // !!! NOT !!! CHANGE_THIS !!!
    ],
    'textarea_field' => [ // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'name'        => 'textarea_field', // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'type'        => 'textarea', // !!! NOT !!! CHANGE_THIS !!!
        'clean'       => 'text', // !!! NOT !!! CHANGE_THIS !!!
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => Config::getCfg('MIN_FIELD_NAME_LEN'), // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'maxlength'   => Config::getCfg('MAX_FIELD_NAME_LEN'), // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'class'       => 'uk-textarea', // !!! NOT !!! CHANGE_THIS !!!
        'rows'        => Config::getCfg('CFG_TEXTAREA_ROWS'), // !!! NOT !!! CHANGE_THIS !!!
        'placeholder' => '',
        'value'       => isset($v['textarea_field']) ? $v['textarea_field'] : '', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'info'        => '',
    ],
    'select_field'   => [ // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'name'        => 'select_field', // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'type'        => 'select', // !!! NOT !!! CHANGE_THIS !!!
        'clean'       => 'str', // or 'int', 'unsInt', 'float'
        'disabled'    => false, // true or false
        'required'    => false, // true or false
        'minlength'   => 2, // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'maxlength'   => 2, // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'check'       => Status::getI()->clear(), // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'class'       => 'uk-select', // !!! NOT !!! CHANGE_THIS !!!
        'placeholder' => '', // !!! NOT !!! CHANGE_THIS !!!
        'value'       => isset($v['select_field']) ? Status::getI()->option($v['select_field']) : Status::getI()->option(),
        'info'        => '', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
    ],
    'checkbox_field' => [ // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'name'        => 'checkbox_field', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'type'        => 'checkbox', // !!! NOT !!! CHANGE_THIS !!!
        'checked'     => false, // true or false
        'clean'       => 'unsInt', // !!! NOT !!! CHANGE_THIS !!!
        'disabled'    => false, // !!! NOT !!! CHANGE_THIS !!!
        'required'    => false, // true or false
        'minlength'   => 1, // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'maxlength'   => 1, // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'class'       => 'uk-checkbox', // !!! NOT !!! CHANGE_THIS !!!
        'placeholder' => '', // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
        'value'       => 1, // VALUE IS EXAMPLE
        'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('FIELD_NAME_INFO'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
    ],
    'fieldset_field' => [ // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'name'        => 'fieldset_field', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'type'        => 'fieldset_checkbox', // !!! NOT !!! CHANGE_THIS !!!
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'fields_path' => ForAll::contIncPath() . 'fields.php', // or ForAll::compIncPath() . 'fields.php',
        'value'       => isset($v['fieldset_field']) ? $v['fieldset_field'] : '', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'info'        => '', // !!! NOT !!! CHANGE_THIS !!!
    ],
];
