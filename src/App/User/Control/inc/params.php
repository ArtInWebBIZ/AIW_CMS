<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\User\Control\Req\Func;
use Core\Plugins\Dll\ForAll;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'USER_CONTROL',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'user',
        'page_link'           => 'user/control/',
        'filters_clear_link'  => 'user/control-clear/',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'order_by'            => 'DESC',
        'fields_in_body'      => ['id', 'group', 'created', 'edited', 'edited_count', 'status'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [],
    ];
