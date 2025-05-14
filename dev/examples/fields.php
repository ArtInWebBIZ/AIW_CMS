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
    'text_field'     => [ // VALUE IS EXAMPLE TEXT FIELD !!! CHANGE THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'name'        => 'text_field', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'type'        => 'text', // !!! NOT CHANGE THIS !!!
        'clean'       => 'str', // or 'int', 'unsInt', 'float'
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => Config::getCfg('MIN_EXAMPLE_LEN'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'maxlength'   => Config::getCfg('MAX_EXAMPLE_LEN'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'class'       => 'uk-input', // !!! NOT CHANGE THIS !!!
        'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('FIELD_NAME_EXAMPLE'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'value'       => isset($v['text_field']) ? $v['text_field'] : '', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::sprintf('FIELD_NAME_INFO', ...[ // VALUE IS EXAMPLE !!! CHANGE THIS !!!
            Config::getCfg('MIN_EXAMPLE_LEN'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
            Config::getCfg('MAX_EXAMPLE_LEN'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        ]), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
    ],
    'link_field'     => [ // VALUE IS EXAMPLE LINK FIELD !!! CHANGE THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'name'        => 'link_field', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'type'        => 'text', // !!! NOT CHANGE THIS !!!
        'clean'       => 'link', // !!! NOT CHANGE THIS !!!
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => Config::getCfg('CFG_MIN_LINK_LEN'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'maxlength'   => Config::getCfg('CFG_MAX_LINK_LEN'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'class'       => 'uk-input', // !!! NOT CHANGE THIS !!!
        'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('EXAMPLE_SOC_NET_PAGE'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'value'       => isset($v['link_field']) ? $v['link_field'] : '', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::sprintf('FIELD_SOC_NET_PAGE_ERROR', ...[ // VALUE IS EXAMPLE !!! CHANGE THIS !!!
            Config::getCfg('CFG_MIN_LINK_LEN'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
            Config::getCfg('CFG_MAX_LINK_LEN'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        ]), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
    ],
    'file_field'     => [ // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE THIS !!!
        'label'         => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'name'          => 'file_field', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'type'          => 'file', // !!! NOT CHANGE THIS !!!
        'clean'         => '', // !!! NOT CHANGE THIS !!!
        'disabled'      => false, // true or false
        'required'      => true, // true or false
        'MAX_file_size' => Config::getCfg('MAX_FILE_SIZE'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'allow_file_type' => ['jpg', 'jpeg', 'jpe'], // VALUE IS EXAMPLE !!!
        'deny_file_type'  => ['exe', 'bat', 'ini', 'iso'], // VALUE IS EXAMPLE !!!
        'class'         => 'uk-input', // !!! NOT CHANGE THIS !!!
        'placeholder'   => Trl::_('OV_FILE_SELECT'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'value'         => is_array($v['file_field']) ? $v['file_field'] : '',
        'info'          => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('FIELD_NAME_INFO'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
    ],
    'multiple_field'   => [ // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE THIS !!!
        'label'         => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE THIS !!!
        'name'          => 'multiple_field', // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE THIS !!!
        'type'          => 'multiple', // !!! NOT CHANGE THIS !!!
        'clean'         => '', // !!! NOT CHANGE THIS !!!
        'disabled'      => false, // true or false
        'required'      => true, // true or false
        'MAX_file_size' => Config::getCfg('MAX_IMAGES_SIZE'), // VALUE IS EXAMPLE FILE INSERT FIELD !!! CHANGE THIS !!!
        'allow_file_type' => ['jpg', 'jpeg', 'jpe'], // VALUE IS EXAMPLE !!!
        'deny_file_type'  => ['exe', 'bat', 'ini', 'iso'], // VALUE IS EXAMPLE !!!
        'class'         => 'uk-input', // !!! NOT CHANGE THIS !!!
        'placeholder'   => Trl::_('OV_FILE_SELECT'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'value'         => is_array($v['file_field']) ? $v['file_field'] : '',
        'info'          => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('FIELD_NAME_INFO'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
    ],
    'hidden_field'   => [ // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'label'       => '', // !!! NOT CHANGE THIS !!!
        'name'        => 'hidden_field', // !!! NOT CHANGE THIS !!!
        'type'        => 'hidden', // !!! NOT CHANGE THIS !!!
        'clean'       => 'str', // !!! NOT CHANGE THIS !!!
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => 32, // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'maxlength'   => 32, // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'class'       => '', // !!! NOT CHANGE THIS !!!
        'placeholder' => '', // !!! NOT CHANGE THIS !!!
        'value'       => isset($v['hidden_field']) ? $v['hidden_field'] : '', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'info'        => '', // !!! NOT CHANGE THIS !!!
    ],
    'textarea_field' => [ // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'name'        => 'textarea_field', // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'type'        => 'textarea', // !!! NOT CHANGE THIS !!!
        'clean'       => 'text', // !!! NOT CHANGE THIS !!!
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => Config::getCfg('MIN_FIELD_NAME_LEN'), // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'maxlength'   => Config::getCfg('MAX_FIELD_NAME_LEN'), // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'class'       => 'uk-textarea', // !!! NOT CHANGE THIS !!!
        'rows'        => Config::getCfg('CFG_TEXTAREA_ROWS'), // !!! NOT CHANGE THIS !!!
        'placeholder' => '',
        'value'       => isset($v['textarea_field']) ? $v['textarea_field'] : '', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'info'        => '',
    ],
    'select_field'   => [ // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'name'        => 'select_field', // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'type'        => 'select', // !!! NOT CHANGE THIS !!!
        'clean'       => 'str', // or 'int', 'unsInt', 'float'
        'disabled'    => false, // true or false
        'required'    => false, // true or false
        'minlength'   => 2, // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'maxlength'   => 2, // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'check'       => Status::getI()->clear(), // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'class'       => 'uk-select', // !!! NOT CHANGE THIS !!!
        'placeholder' => '', // !!! NOT CHANGE THIS !!!
        'value'       => isset($v['select_field']) ?
            Status::getI()->option((string) $v['select_field']) : // (sting) - TYPE IS EXAMPLE !!! CHANGE THIS !!!
            Status::getI()->option(),
        'info'        => '', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
    ],
    'checkbox_field' => [ // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'name'        => 'checkbox_field', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'type'        => 'checkbox', // !!! NOT CHANGE THIS !!!
        'checked'     => false, // true or false
        'clean'       => 'unsInt', // !!! NOT CHANGE THIS !!!
        'disabled'    => false, // !!! NOT CHANGE THIS !!!
        'required'    => false, // true or false
        'minlength'   => 1, // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'maxlength'   => 1, // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'class'       => 'uk-checkbox', // !!! NOT CHANGE THIS !!!
        'placeholder' => '', // VALUE IS EXAMPLE  !!! CHANGE THIS !!!
        'value'       => 1, // VALUE IS EXAMPLE
        'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('FIELD_NAME_INFO'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
    ],
    'fieldset_field' => [ // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'label'       => Trl::_('FIELD_NAME'), // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'name'        => 'fieldset_field', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'type'        => 'fieldset_checkbox', // !!! NOT CHANGE THIS !!!
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'fields_path' => ForAll::contIncPath() . 'fields.php', // or ForAll::compIncPath() . 'fields.php',
        'value'       => isset($v['fieldset_field']) ? $v['fieldset_field'] : '', // VALUE IS EXAMPLE !!! CHANGE THIS !!!
        'info'        => '', // !!! NOT CHANGE THIS !!!
    ],
];
