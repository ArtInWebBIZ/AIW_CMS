<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\SearchBotsIp\Index\Req\Func;
use Core\Plugins\Dll\ForAll;

return
    [
        'tpl'                 => 'admin',
        'title'               => 'SBIP_CONTROL',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'search_bots_ip',
        'page_link'           => 'search-bots-ip/',
        'filters_clear_link'  => 'search-bots-ip/index-clear/',
        'template'            => ForAll::contIncPath() . 'template.php',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'order_by'            => 'ASC',
        'fields_in_body'      => ['id', 'start_range', 'end_range', 'engine_name'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [],
    ];
