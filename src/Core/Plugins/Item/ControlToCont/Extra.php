<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Item\ControlToCont;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Extra as CheckExtra;
use Core\Plugins\ParamsToSql;

class Extra
{
    private static $extraItem = null;
    /**
     * Return in array first sql to database,
     * and array extra values
     * @return array or empty array ([])
     */
    public static function extraItem(array $extra, string $currControllerName): array
    {
        if ($extra != []) {

            $tables     = '';
            $whereId    = '';
            $where      = '';
            $extraArray = [];
            /**
             * Sorted fields in type
             */
            $sortedExtraFields = Fields::checkFieldsType($extra, $currControllerName);
            /**
             * If isset ITEMS table fields
             */
            if (isset($sortedExtraFields['itemFields'])) {

                $itemFields = $sortedExtraFields['itemFields'];

                $item = CheckExtra::whereAndArray($itemFields, 'item');

                $where      = $item['where'];
                $extraArray = array_merge($extraArray, $item['array']);
                #
            }
            /**
             * If isset FILTERS table fields
             */
            if (isset($sortedExtraFields['filtersFields'])) {

                $filtersFields = $sortedExtraFields['filtersFields'];

                $filtersTable = 'item_' . $currControllerName;
                $tables .= ', ' . $filtersTable;
                $whereId .= 'item.id = ' . $filtersTable . '.item_id AND ';

                $filters = CheckExtra::whereAndArray($filtersFields, $filtersTable);

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

        return self::$extraItem;
    }
}
