<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\Blog\EditHistory\Req\Func;
use Core\Plugins\Check\Item;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;
use Core\Router;

return
    [
        'tpl'                 => 'admin',
        'section_css'         => Style::control()['section_css'],
        'container_css'       => Style::control()['container_css'],
        'overflow_css'        => Style::control()['overflow_css'],
        'title'               => 'OV_EDIT_HISTORY',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'item_edit_log',
        'page_link'           => Router::getRoute()['controller_url'] . '/edit-history/',
        'filters_clear_link'  => Router::getRoute()['controller_url'] . '/edit-history-clear/',
        'order_by'            => 'DESC',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'fields_in_body'      => ['id', 'item_id', 'editor_id', 'edited_field', 'old_value', 'new_value', 'edited'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [
            'item_controller_id' => [
                'sql'            => 'item_controller_id = :item_controller_id AND ',
                'filters_values' => Item::getI()->currControllerId(),
            ],
        ],
    ];
