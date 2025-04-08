<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\ViewLog\Control\Req\Func;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'OV_ATTENDANCE',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'view_log',
        'page_link'           => 'view-log/control/',
        'filters_clear_link'  => 'view-log/control-clear/',
        'filter_fields'       => PATH_APP . 'ViewLog' . DS . 'Control' . DS . 'inc' . DS . 'filters.php',
        'order_by'            => 'DESC',
        'control_header'      => PATH_APP . 'ViewLog' . DS . 'Control' . DS . 'inc' . DS . 'header.php',
        'control_body'        => PATH_APP . 'ViewLog' . DS . 'Control' . DS . 'inc' . DS . 'body.php',
        'fields_in_body'      => ['id', 'lang', 'url_id', 'user_id', 'user_ip', 'token', 'created'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [],
    ];
