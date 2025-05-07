<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\ItemController\EditHistory\Req\Func;
use Core\Config;
use Core\Plugins\Lib\ForAll;

return
    [
        'tpl'                 => 'admin',
        'title'               => 'OV_EDIT_HISTORY',
        'item_heading'        => 'ITEM_CONTROLLER_URL',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'item_controller_edit_log',
        'page_link'           => 'item-controller/edit-history/',
        'filters_clear_link'  => 'item-controller/edit-history-clear/',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'template'            => ForAll::contIncPath() . 'template.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'order_by'            => 'DESC',
        'paginationStep'      => Config::getCfg('CFG_PAGINATION'),
        'fields_in_body'      => ['id', 'edited_id', 'editor_id', 'edited_field', 'old_value', 'new_value', 'edited'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [],
    ];
