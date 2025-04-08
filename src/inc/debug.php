<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

// use Core\Plugins\Model\DB;
// use Core\Plugins\ParamsToSql;

function debug($data)
{
    echo '<pre>' . print_r($data, true) . '</pre>';
}

// function toTmp(string $value)
// {
//     return DB::getI()->add(
//         [
//             'table_name' => 'tmp',
//             'set'        => ParamsToSql::getSet(
//                 $set = [
//                     'value' => $value,
//                 ]
//             ),
//             'array'      => $set,
//         ]
//     );
// }
