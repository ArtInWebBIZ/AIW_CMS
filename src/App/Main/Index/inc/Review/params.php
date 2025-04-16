<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Dll\ForAll;

return
    [
        'access'              => true,
        'content_type'        => 'review',
        'page_link'           => 'review/',
        'filters_clear_link'  => 'review/index-clear/',
        'template'            => ForAll::contIncPath() . 'Review' . DS . 'template.php',
        'filter_fields'       => ForAll::contIncPath() . 'Review' . DS . 'filters.php',
        'control_body'        => ForAll::contIncPath() . 'Review' . DS . 'body.php',
        'order_by'            => 'DESC',
        'control_header'      => '',
        'paginationStep'      => Config::getCfg('CFG_PAGINATION'),
        'fields_in_body'      => ['id', 'author_id', 'text', 'rating', 'created', 'edited', 'status'],
        'filter_button_label' => 'LABEL_SELECT',
        'extra'               => [
            'rating' => [
                'sql'            => '`rating` = :rating AND ',
                'filters_values' => 5,
            ],
            'status' => [
                'sql'            => '`status` = :status AND ',
                'filters_values' => ForAll::contentStatus('review')['REVIEW_PUBLISHED'],
            ],
        ],
        'extra_limit'            => 3,
    ];
