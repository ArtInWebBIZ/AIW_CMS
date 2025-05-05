<?php

use Core\Plugins\Fields\ItemController;

defined('AIW_CMS') or die;

return [
    'controller_url' => ItemController::getI()->controllerUrl(isset($v['controller_url']) ? $v['controller_url'] : ''),
    'filters_table'  => ItemController::getI()->filtersTable(isset($v['filters_table']) ? $v['filters_table'] : ''),
];
