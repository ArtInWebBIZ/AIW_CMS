<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\ViewLog\ControlIndex\Req\Func;
use Core\Plugins\Lib\ForAll;
use Core\Router;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'OV_ATTENDANCE_INDEX',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'view_index_log',
        'page_link'           => Router::getRoute()['controller_url'] . '/control-index/',
        'filters_clear_link'  => Router::getRoute()['controller_url'] . '/control-index-clear/',
        'order_by'            => 'DESC',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'fields_in_body'      => ['id', 'lang', 'url_id', 'user_id', 'user_ip', 'token', 'created'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [],
    ];
