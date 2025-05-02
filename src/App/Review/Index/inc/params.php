<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use App\Review\Index\Req\Func;
use Core\Config;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;

return
    [
        'tpl'         => 'index',
        'title'       => 'REVIEW_REVIEWS',

        'robots'        => ForAll::robots(),
        'canonical'     => ForAll::canonical(),
        'alternate'     => ForAll::alternate(),
        'sitemap_order' => ForAll::sitemapOrder(),

        'access'              => Func::getI()->checkAccess(),
        'section_css'         => Style::content()['section_css'],
        'container_css'       => Style::content()['container_css'],
        'overflow_css'        => Style::content()['overflow_css'],
        'content_type'        => 'review',
        'page_link'           => 'review/',
        'filters_clear_link'  => 'review/index-clear/',
        'template'            => ForAll::contIncPath() . 'template.php',
        'filter_fields'       => ForAll::contIncPath() . 'filters.php',
        'control_body'        => ForAll::contIncPath() . 'body.php',
        'order_by'            => 'DESC',
        'control_header'      => '',
        'paginationStep'      => Config::getCfg('CFG_PAGINATION'),
        'fields_in_body'      => ['id', 'author_id', 'text', 'rating', 'created', 'edited', 'status'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [
            'status' => [
                'sql'            => '`status` = :status AND ',
                'filters_values' => ForAll::compIncFile('Review', 'status')['REVIEW_PUBLISHED'],
            ],
        ]
    ];
