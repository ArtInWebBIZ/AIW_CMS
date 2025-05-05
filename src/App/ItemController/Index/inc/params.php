<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\ItemController\Index\Req\Func;
use Core\{Config, Router};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;

return
    [
        'tpl'                 => 'admin',
        'section_css'         => Style::control()['section_css'],
        'container_css'       => Style::control()['container_css'],
        'overflow_css'        => Style::control()['overflow_css'],
        'title'               => 'ITEM_CONTROLLER_URL',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'item_controller',
        'page_link'           => Router::getRoute()['controller_url'] . '/',
        'filters_clear_link'  => Router::getRoute()['controller_url'] . '/index-clear/',
        'order_by'            => 'ASC',
        'template'            => ForAll::contIncPath() . 'template.php',
        'filter_fields'       => ForAll::contIncPath() . 'fields.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'paginationStep'      => Config::getCfg('CFG_PAGINATION'),
        'fields_in_body'      => ['id', 'controller_url', 'filters_table', 'created'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [],
    ];
