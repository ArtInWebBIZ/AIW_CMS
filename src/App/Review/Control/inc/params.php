<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\Review\Control\Req\Func;
use Core\Plugins\Lib\ForAll;

return
    [
        'tpl'                 => 'admin',
        'template'            => PATH_TPL . 'control.php',
        'title'               => 'REVIEW_REVIEWS',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'review',
        'page_link'           => 'review/control/',
        'filters_clear_link'  => 'review/control-clear/',
        'order_by'            => 'DESC',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'fields_in_body'      => ['id', 'author_id', 'rating', 'created', 'edited', 'status'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [],
    ];
