<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Fields\Filters;

return [
    'edited_id'   => Filters::getI()->editedId(isset($v['edited_id']) ? $v['edited_id'] : ''),
    'editor_id'   => Filters::getI()->editorId(isset($v['editor_id']) ? $v['editor_id'] : ''),
    'edited_from' => Filters::getI()->editedFrom(isset($v['edited_from']) ? $v['edited_from'] : ''),
    'edited_to'   => Filters::getI()->editedTo(isset($v['edited_to']) ? $v['edited_to'] : ''),
    'order_by'    => Filters::getI()->order(isset($v['order_by']) ? $v['order_by'] : ''),
];
