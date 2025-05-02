<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

defined('AIW_CMS') or die;

/**
 * Get values from one tables column
 * @return array // array or []
 */
$return = DB::getI()->getColumn(
    [
        'table_name'           => 'table_name', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'field_name'           => 'field_name', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'where'                => ParamsToSql::getSql(
            $where = [
                'field_name_1' => 'field_name_1', // !!! CHANGE_THIS !!!
                'field_name_2' => 'field_name_2', // !!! CHANGE_THIS !!!
            ]
        ),
        'order_dy_field_name'  => 'id', // VALUE IS EXAMPLE !!! CHANGE THIS VALUE IF NEEDED !!!
        'order_dy_direction'   => 'ASC', // or DESC 
        'offset'               => 0, // OR PARAMS FROM PAGINATION
        'limit'                => 0, // 0 - unlimited
        'array'                => $where, // !!! NOT !!! CHANGE_THIS !!!
    ]
);
