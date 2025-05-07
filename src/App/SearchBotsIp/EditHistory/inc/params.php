<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\SearchBotsIp\EditHistory\Req\Func;
use Core\Config;
use Core\Plugins\Lib\ForAll;

return
    [
        'tpl'                 => 'admin',
        'title'               => 'OV_EDIT_HISTORY',
        'item_heading'        => 'SBIP_CONTROL',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'search_bots_ip_edit_log',
        'page_link'           => 'search-bots-ip/edit-history/',
        'filters_clear_link'  => 'search-bots-ip/edit-history-clear/',
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
