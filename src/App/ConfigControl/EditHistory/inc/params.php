<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\ConfigControl\EditHistory\Req\Func;
use Core\Plugins\Dll\ForAll;
use Core\Router;

return
    [
        'tpl'                 => 'admin',
        'title'               => 'CONFIG_EDIT_HISTORY',
        'template'            => PATH_TPL . 'control.php',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'config_control_edit_log',
        'page_link'           => Router::getRoute()['controller_url'] . '/edit-history/',
        'filters_clear_link'  => Router::getRoute()['controller_url'] . '/edit-history-clear/',
        'order_by'            => 'DESC',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'fields_in_body'      => ['id', 'edited_id', 'editor_id', 'edited_params', 'old_value', 'new_value', 'edited'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => Func::getI()->extra(),
    ];
