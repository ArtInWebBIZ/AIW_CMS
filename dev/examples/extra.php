<?php

use Core\Plugins\ParamsToSql;

defined('AIW_CMS') or die;

function extra()
{
    /**
     * Extra params for ITEM content type
     * (from MANY tables)
     */

    // ALL VALUES IS EXAMPLE  !!! CHANGE_THIS !!!

    [
        'field_name' => [
            'value'      => [1, 2, 3, 4], # array or integer or string
            'comparison' => '>=', # NOT OBLIGATORY FIELD !!! If value is integer Default - '='
            'comparison' => 'NOT IN', # NOT OBLIGATORY FIELD !!! If value is array Default - 'IN'
            'logic'      => ' OR  ', # NOT OBLIGATORY FIELD !!! Default - ' AND '
        ],
    ];

    /**
     * Extra params for other content
     * (from ONE table)
     */

    // ALL VALUES IS EXAMPLE  !!! CHANGE_THIS !!!

    $in = ParamsToSql::getInSql([24, 43, 52], 'NOT IN', 'edited_id');

    [
        'user_id' => [
            'sql'            => '`user_id` = :user_id OR  ',
            'filters_values' => 'Auth::getUserId()',
        ],
        'status' => [
            'sql'            => '`status` > :status AND ',
            'filters_values' => 5,
        ],
        'edited_id' => [
            'sql'            => '`edited_id` ' . $in['in'] . ' AND ',
            'filters_values' => $in['array'],
        ],
    ];
}
