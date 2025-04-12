<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Trl};
use Core\Plugins\Fields\Filters;
use Core\Plugins\Select\Review\Fields;

return [
    'edited_id'    => Filters::getI()->editedId(isset($v['edited_id']) ? $v['edited_id'] : ''),
    'editor_id'    => Filters::getI()->editorId(isset($v['editor_id']) ? $v['editor_id'] : ''),
    'edited_field' => [
        'label'       => Trl::_('OV_EDITED_FIELD'),
        'name'        => 'edited_field',
        'type'        => 'select',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => false,
        'check'       => Fields::getI()->clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['edited_field']) ? Fields::getI()->option($v['edited_field']) : Fields::getI()->option(),
        'info'        => '',
    ],
    'edited_from'  => Filters::getI()->editedFrom(isset($v['edited_from']) ? $v['edited_from'] : ''),
    'edited_to'    => Filters::getI()->editedTo(isset($v['edited_to']) ? $v['edited_to'] : ''),
    'order_by'     => Filters::getI()->order(isset($v['order_by']) ? $v['order_by'] : ''),
];
