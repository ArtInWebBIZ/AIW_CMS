<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Model\DB;

$exampleArray = [ // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
    [
        'field_1' => 'field_1_value_0',
        'field_2' => 'field_2_value_0',
        'field_3' => 'field_3_value_0',
    ],
    [
        'field_1' => 'field_1_value_1',
        'field_2' => 'field_2_value_1',
        'field_3' => 'field_3_value_1',
    ],
    [
        'field_1' => 'field_1_value_2',
        'field_2' => 'field_2_value_2',
        'field_3' => 'field_3_value_2',
    ],
];

$tableName = 'example_edit_log'; // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
/**
 * Insert many rows to database table from values in array
 * @param string $tableName
 * @param array  $valueInArray
 * @return boolean
 */
$return = DB::getI()->insertInto($tableName, $exampleArray);
