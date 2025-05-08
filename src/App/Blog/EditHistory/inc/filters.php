<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Fields\{Item, Filters};
use Core\Trl;
use Comp\Blog\Lib\Select\FilterFields;
use Core\Config;

$itemId = Item::getI()->itemId(isset($v['item_id']) ? $v['item_id'] : '');
$itemId['label'] = Trl::_('BLOG_ID');

return [
    'item_id'     => $itemId,
    'editor_id'   => Filters::getI()->editorId(isset($v['editor_id']) ? $v['editor_id'] : ''),
    'edited_field'   => [
        'label'       => Trl::_('OV_EDITED_FIELD'),
        'name'        => 'edited_field',
        'type'        => 'select',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_FILTER_NAME_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_FILTER_NAME_LEN'),
        'check'       => FilterFields::clear(),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['edited_field']) ? FilterFields::option($v['edited_field']) : FilterFields::option(),
        'info'        => '',
    ],
    'edited_from' => Filters::getI()->editedFrom(isset($v['edited_from']) ? $v['edited_from'] : ''),
    'edited_to'   => Filters::getI()->editedTo(isset($v['edited_to']) ? $v['edited_to'] : ''),
    'order_by'    => Filters::getI()->order(isset($v['order_by']) ? $v['order_by'] : ''),
];
