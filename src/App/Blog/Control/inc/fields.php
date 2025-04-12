<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Fields\Filters;

return [
    'author_id'    => Filters::getI()->authorId(isset($v['author_id']) ? $v['author_id'] : ''),
    'created_from' => Filters::getI()->createdFrom(isset($v['created_from']) ? $v['created_from'] : ''),
    'created_to'   => Filters::getI()->createdTo(isset($v['created_to']) ? $v['created_to'] : ''),
    'order_by'     => Filters::getI()->order(isset($v['order_by']) ? $v['order_by'] : ''),
];
