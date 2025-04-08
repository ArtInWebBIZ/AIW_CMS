<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\ViewLog\ControlManagers\Req\Func;
use Core\Plugins\Dll\ForAll;
use Core\Router;

return
    [
        'tpl'                 => 'admin',
        'section_css'         => 'uk-padding-remove-top',
        'title'               => 'OV_ATTENDANCE_MANAGERS',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'view_management_log',
        'page_link'           => Router::getRoute()['controller_url'] . '/control-managers/',
        'filters_clear_link'  => Router::getRoute()['controller_url'] . '/control-managers-clear/',
        'order_by'            => 'DESC',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'fields_in_body'      => ['id', 'lang', 'url_id', 'user_id', 'user_ip', 'token', 'created'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [],
    ];
