<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, Trl};
use Core\Plugins\Fields\Filters;
use Core\Plugins\Select\User\FieldsOption;

return [
    'editor_id'    => [
        'label'       => Trl::_('LABEL_EDITOR_ID'),
        'name'        => 'editor_id',
        'type'        => 'text',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['editor_id']) ? $v['editor_id'] : '',
        'info'        => '',
        'icon'        => '',
    ],
    'edited_field' => [
        'label'       => Trl::_('OV_EDITED_FIELD'),
        'name'        => 'edited_field',
        'type'        => 'select',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => false,
        'check'       => FieldsOption::getI()->fieldsOptionClear(),
        'minlength'   => Config::getCfg('CFG_MIN_PASS_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_PASS_LEN'),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['edited_field']) ? FieldsOption::getI()->fieldsOptionHtml($v['edited_field']) : FieldsOption::getI()->fieldsOptionHtml(),
        'info'        => '',
    ],
    'edited_from'  => Filters::getI()->editedFrom(isset($v['edited_from']) ? $v['edited_from'] : ''),
    'edited_to'    => Filters::getI()->editedTo(isset($v['edited_to']) ? $v['edited_to'] : ''),
];
