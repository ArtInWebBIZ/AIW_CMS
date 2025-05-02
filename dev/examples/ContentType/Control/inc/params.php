<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\ContentType\Control\Req\Func;
use Core\Config;
use Core\Plugins\Lib\ForAll;

// ALL VALUES IS EXAMPLE  !!! CHANGE_THIS !!!

return
    [
        'tpl'                 => 'index', // select render page template: index - for all users, or 'admin'
        'title'               => 'EXAMPLE_PAGE_TITLE',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'content_table',
        'page_link'           => 'ContentType/',
        'filters_clear_link'  => 'ContentType/Control-clear/',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',  // REQUIRED FILE – array or []
        'template'            => ForAll::contIncPath() . 'template.php', // NOT REQUIRED FILE - else include Core\Modules\Control\Require\controlTpl.php
        'control_header'      => ForAll::contIncPath() . 'header.php',   // REQUIRED FILE – value or ''
        'control_body'        => ForAll::contIncPath() . 'body.php',     // REQUIRED FILE
        'order_by'            => 'DESC',
        'paginationStep'      => Config::getCfg('CFG_PAGINATION'),
        'fields_in_body'      => ['id', 'author_id', 'field_name', 'old_value', 'new_value', 'edited'],
        'filter_button_label' => 'LABEL_SELECT',
        // 'extra'               => [],
        'extra'               => [
            'status' => [
                'sql'            => '`status` = :status AND ',
                'filters_values' => 1,
            ],
        ],
        'meta_params' => Func::getI()->defPageParams(),
    ];
