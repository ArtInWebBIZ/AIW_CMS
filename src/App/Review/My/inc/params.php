<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\Review\My\Req\Func;
use Core\Auth;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;

return
    [
        'tpl'                 => 'index',
        'section_css'         => Style::control()['section_css'],
        'container_css'       => Style::control()['container_css'],
        'overflow_css'        => Style::control()['overflow_css'],
        'title'               => 'REVIEW_REVIEWS',
        'access'              => Func::getI()->checkAccess(),
        'content_type'        => 'review',
        'page_link'           => 'review/my/',
        'filters_clear_link'  => 'review/my-clear/',
        'order_by'            => 'DESC',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_header'      => ForAll::contIncPath() . 'header.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'fields_in_body'      => ['id', 'author_id', 'rating', 'created', 'edited', 'status'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [
            'author_id' => [
                'sql'            => '`author_id` = :author_id AND ',
                'filters_values' => Auth::getUserId(),
            ],
        ],
    ];
