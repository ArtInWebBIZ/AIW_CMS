<?php

use Comp\Review\Lib\Fields;
use Core\Plugins\Fields\Filters;

defined('AIW_CMS') or die;

$authorId             = Fields::getI()->authorId(isset($v['author_id']) ? $v['author_id'] : '');
$authorId['required'] = false;

$status             = Fields::getI()->status(isset($v['status']) ? $v['status'] : '');
$status['required'] = false;

return [
    'id'           => Fields::getI()->id(isset($v['id']) ? $v['id'] : ''),
    'author_id'    => $authorId,
    'status'       => $status,
    'created_from' => Filters::getI()->createdFrom(isset($v['created_from']) ? $v['created_from'] : ''),
    'created_to'   => Filters::getI()->createdTo(isset($v['created_to']) ? $v['created_to'] : ''),
    'order_by'     => Filters::getI()->order(isset($v['order_by']) ? $v['order_by'] : ''),
];
