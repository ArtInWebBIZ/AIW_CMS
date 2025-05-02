<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

/**
 * @return array // array or []
 */
$return = DB::getI()->getNeededField(
    [
        'table_name'          => 'table_name', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'field_name'          => 'needed_field_name', // example 'id' or 'id`,`edited_count`,`brand_status' VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'where'               => ParamsToSql::getSql(
            $where = [
                'fields_name_1' => 'fields_value_1', // !!! CHANGE_THIS !!!
                'fields_name_2' => 'fields_value_2', // !!! CHANGE_THIS !!!
            ]
        ),
        'array'               => $where, // !!! NOT !!! CHANGE_THIS !!!
        'order_by_field_name' => 'id', // !!! CHANGE THIS VALUE IF NEEDED !!!
        'order_by_direction'  => 'ASC', // or DESC
        'offset'              => 0, // OR PARAMS FROM PAGINATION
        'limit'               => 0, // 0 - unlimited
    ]
);
