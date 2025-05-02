<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Model\DB;

/**
 * @return mixed // id or 0
 */
$return = DB::getI()->fieldset(
    [
        'table_name'  => 'table_name', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'item_id'     => 123, // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
        'field_value' => [1, 2, 3, 4, 5, 6, 7], // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
    ]
);
