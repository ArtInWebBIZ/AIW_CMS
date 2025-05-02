<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Router};
use App\ConfigControl\Control\Req\Func;
use Core\Plugins\Lib\ForAll;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'CONFIG_CONTROL',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'config_control',
        'page_link'           => Router::getRoute()['controller_url'] . '/control/',
        'filters_clear_link'  => Router::getRoute()['controller_url'] . '/control-clear/',
        'order_by'            => 'ASC',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'fields_in_body'      => ['id', 'params_name', 'params_value', 'value_type', 'group_access', 'edited'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [
            'group_access' => [
                'sql'            => '`group_access` <= :group_access AND ',
                'filters_values' => Auth::getUserGroup(),
            ],
        ],
    ];
