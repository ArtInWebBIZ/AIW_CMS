<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\Plugins\ParamsToSql;
use Core\Plugins\Item\Control\Func;

class Extra
{
    private static $extraItem  = null;
    /**
     * Return in array first sql to database,
     * and array extra values
     * @return array or empty array ([])
     */
    public static function extraItem(array $extra): array
    {
        if (self::$extraItem === null) {

            if ($extra != []) {

                $tables     = '';
                $whereId    = '';
                $where      = '';
                $extraArray = [];
                /**
                 * Sorted fields in type
                 */
                $sortedExtraFields = Func::getI()->checkFieldsType($extra);
                /**
                 * If isset ITEMS table fields
                 */
                if (isset($sortedExtraFields['itemFields'])) {

                    $itemFields = $sortedExtraFields['itemFields'];

                    $item = self::whereAndArray($itemFields, 'item');

                    $where      = $item['where'];
                    $extraArray = array_merge($extraArray, $item['array']);
                    #
                }
                /**
                 * If isset FILTERS table fields
                 */
                if (isset($sortedExtraFields['filtersFields'])) {

                    $filtersFields = $sortedExtraFields['filtersFields'];

                    $filtersTable = 'item_' . Item::getI()->currControllerName();
                    $tables .= ', ' . $filtersTable;
                    $whereId .= 'item.id = ' . $filtersTable . '.item_id AND ';

                    $filters = self::whereAndArray($filtersFields, $filtersTable);

                    $where     .= $filters['where'];
                    $extraArray = array_merge($extraArray, $filters['array']);
                    #
                }
                /**
                 * If isset FIELDSET tables fields
                 */
                if (isset($sortedExtraFields['fieldsetFields'])) {

                    $fieldsetFields = $sortedExtraFields['fieldsetFields'];

                    foreach ($fieldsetFields as $key => $value) {

                        $fieldset = [];

                        $fieldsetTable = 'item_' . $key;
                        $tables .= ', ' . $fieldsetTable;
                        $whereId .= 'item.id = ' . $fieldsetTable . '.item_id AND ';

                        $comparison = isset($value['comparison']) ? $value['comparison'] : 'IN';

                        $fieldset = ParamsToSql::getInSql($value['value'], $comparison, 'extra_' . $key);

                        $where     .= 'item_' . $key . '.' . $key . $fieldset['in'] . ' AND ';
                        $extraArray = array_merge($extraArray, $fieldset['array']);
                        #
                    }
                    unset($key, $value);
                }

                self::$extraItem['tables']   = $tables;
                self::$extraItem['where_id'] = $whereId;
                self::$extraItem['where']    = $where != '' ? '(' . substr($where, 0, -5) . ') AND ' : '';
                self::$extraItem['array']    = $extraArray;
                #
            } else {
                self::$extraItem = [];
            }
        }

        return self::$extraItem;
    }
    /**
     * Return in:
     * key ['where'] prepare where sql,
     * key ['array'] values to prepare sql
     * @param array  $fieldsList
     * @param string $tablename
     * @return array
     */
    public static function whereAndArray(array $fieldsList, string $tablename): array
    {
        $where = '';
        $array = [];

        foreach ($fieldsList as $key => $value) {

            if (is_array($value['value'])) {
                $comparison = isset($value['comparison']) ? $value['comparison'] : 'IN';
            } else {
                $comparison = isset($value['comparison']) ? $value['comparison'] : '=';
            }

            $logic = isset($value['logic']) ? $value['logic'] : ' AND ';

            if (is_array($value['value'])) {
                $in = ParamsToSql::getInSql($value['value'], $comparison, 'extra_' . $key);
                $where .= $key . $in['in'] . $logic;
                $array = array_merge($array, $in['array']);
            } elseif (stripos($key, "_from") !== false) {
                $where .= $tablename . '.' . str_replace("_from", "", $key) . ' >= :extra_' . $key . $logic;
            } elseif (stripos($key, "_to") !== false) {
                $where .= $tablename . '.' . str_replace("_to", "", $key) . ' < :extra_' . $key . $logic;
            } else {
                $where .= $tablename . '.' . $key . ' ' . $comparison . ' :extra_' . $key . $logic;
            }

            if (!is_array($value['value'])) {
                $array = array_merge($array, ['extra_' . $key => $value['value']]);
            }
        }
        unset($key, $value);

        return [
            'where' => $where,
            'array' => $array,
        ];
    }
}
