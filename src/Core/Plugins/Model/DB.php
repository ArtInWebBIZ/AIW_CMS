<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Model;

defined('AIW_CMS') or die;

use Core\DB as DbCore;
use Core\Plugins\Check\Item;

class DB
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): DB
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * @param array $params
     * @return integer // id or 0
     */
    public function add(array $params): int
    {
        $tableName = $params['table_name'];
        $set       = $params['set'];
        $array     = $params['array'];

        return (int) DbCore::add(
            "INSERT INTO `$tableName` SET $set",
            $array
        );
    }
    /**
     * @param array $params
     * @return boolean // true or false
     */
    public function boolAdd(array $params): bool
    {
        $tableName = $params['table_name'];
        $set       = $params['set'];
        $array     = $params['array'];

        return DbCore::set(
            "INSERT INTO `$tableName` SET $set",
            $array
        );
    }
    /**
     * @param array $params
     * @return boolean // true or false
     */
    public function fieldset(array $params): bool
    {
        $tableName     = $params['table_name']; // string
        $itemId        = $params['item_id'];
        $fieldValue    = $params['field_value']; // array
        $fieldName     = str_replace("item_", "", $tableName); // string

        $toSave = '';
        $array  = [];

        foreach ($fieldValue as $key => $value) {
            $toSave .= '(:item_id, :controller_id, :' . $fieldName . '_' . $key . '), ';
            $array[$fieldName . '_' . $key] = $value;
        }

        $toSave = mb_substr($toSave, 0, -2);

        $fields = '`item_id`, `item_controller_id`, `' . $fieldName . '`';

        $array = array_merge(
            [
                'item_id'       => $itemId,
                'controller_id' => Item::getI()->currControllerId(),
            ],
            $array
        );

        $query = 'INSERT INTO `' . $tableName . '` (' . $fields . ') VALUES ' . $toSave;

        return (bool) DbCore::set($query, $array);
    }
    /**
     * Insert many rows to database table from values in array
     * @param string $tableName
     * @param array  $valueInArray
     * @return boolean
     */
    public function insertInto(string $tableName, array $valueInArray): bool
    {
        $fieldsList  = [];
        $fieldsValue = [];
        /**
         * Prepare $valueInArray
         */
        foreach ($valueInArray as $key => $value) {

            foreach ($valueInArray[$key] as $fieldName => $fieldValue) {

                if (!isset($fieldsList[$fieldName])) {
                    $fieldsList[$fieldName] = '';
                }

                $fieldsValue[$key][] = $fieldValue;
            }
        }
        unset($key, $value, $fieldName, $fieldValue);

        $fieldsListOk = [];
        /**
         * Prepare fields list
         */
        foreach ($fieldsList as $key => $value) {
            $fieldsListOk[] = $key;
        }
        unset($key, $value, $fieldsList);

        $fieldsList = $fieldsListOk;
        unset($fieldsListOk);

        $fields  = '';

        foreach ($fieldsList as $key => $fieldName) {
            $fields .= '`' . $fieldName . '`, ';
        }
        unset($key, $fieldName);

        $fields = trim($fields, ', ');

        $valueToQuery = '';
        $array        = [];
        /**
         * Prepare value to query and to array
         */
        foreach ($fieldsValue as $key => $value) {

            $newValues = '';

            foreach ($fieldsValue[$key] as $key1 => $value1) {

                $arrayKey = $fieldsList[$key1] . '_' . $key;
                $array[$arrayKey] = is_array($value1) ? json_encode($value1) : $value1;
                $newValues .= ':' . $arrayKey . ', ';
            }

            $newValues = trim($newValues, ', ');

            $valueToQuery .= '(' . $newValues . '), ';
        }
        unset($key, $value, $key1, $value1, $arrayKey);

        $valueToQuery = trim($valueToQuery, ', ');

        $query = 'INSERT INTO `' . $tableName . '` (' . $fields . ') VALUES ' . $valueToQuery;

        return (bool) DbCore::set($query, $array);
    }
    /**
     * @param array $params
     * @return boolean // true or false
     */
    public function update(array $params): bool
    {
        $tableName = $params['table_name'];
        $set       = $params['set'];
        $where     = $params['where'];
        $array     = $params['array'];

        return DbCore::set(
            "UPDATE `$tableName` SET $set WHERE $where",
            $array
        );
    }
    /**
     * @param array $params
     * @return boolean // true or false
     */
    public function delete(array $params): bool
    {
        $tableName = $params['table_name'];
        $where     = $params['where'];
        $array     = $params['array'];

        return DbCore::set(
            "DELETE FROM `$tableName` WHERE $where",
            $array
        );
    }
    /**
     * @param array $params
     * @return mixed // array or false
     */
    public function getRow(array $params): mixed
    {
        $tableName = $params['table_name'];
        $where     = $params['where'];
        $array     = $params['array'];

        return DbCore::getRow(
            "SELECT * FROM `$tableName` WHERE $where",
            $array
        );
    }
    /**
     * @param array $params
     * @return array // array or []
     */
    public function getAll(array $params): array
    {
        $tableName        = $params['table_name'];
        $where            = $params['where'];
        $orderByFieldName = $params['order_by_field_name'];
        $orderByDirection = $params['order_by_direction'];
        $offset           = $params['offset'];
        $limit            = $params['limit'];
        $setLimit         = $limit == 0 ? '' : "LIMIT $offset, $limit";
        $array            = $params['array'];

        return DbCore::getAll(
            "SELECT * FROM `$tableName` WHERE $where
            ORDER BY `$orderByFieldName` $orderByDirection $setLimit",
            $array
        );
    }
    /**
     * @param array $params
     * @return array // array or []
     */
    public function getNeededField(array $params): array
    {
        $tableName        = $params['table_name'];
        $fieldName        = $params['field_name'];
        $where            = $params['where'];
        $orderByFieldName = $params['order_by_field_name'];
        $orderByDirection = $params['order_by_direction'];
        $offset           = $params['offset'];
        $limit            = $params['limit'];
        $array            = $params['array'];
        $setLimit         = $limit == 0 ? '' : "LIMIT $offset, $limit";

        return DbCore::getAll(
            "SELECT `$fieldName` FROM `$tableName` WHERE $where
            ORDER BY `$orderByFieldName` $orderByDirection $setLimit",
            $array
        );
    }
    /**
     * @param array $params
     * @return array // array or []
     */
    public function getNeededItemField(array $params): array
    {
        $tableName        = $params['table_name'];
        $fieldName        = $params['field_name'];
        $where            = $params['where'];
        $array            = $params['array'];

        return DbCore::getAll(
            "SELECT $fieldName FROM $tableName WHERE $where",
            $array
        );
    }
    /**
     * @param array $params
     * @return mixed // value or null
     */
    public function getValue(array $params)
    {
        $tableName = $params['table_name'];
        $select    = $params['select'];
        $where     = $params['where'];
        $array     = $params['array'];

        return DbCore::getValue(
            "SELECT `$select` FROM `$tableName` WHERE $where",
            $array
        );
    }
    /**
     * @param array $params
     * @return mixed // integer or null
     */
    public function countFields(array $params)
    {
        $tableName = $params['table_name'];
        $fieldName = $params['field_name'];
        $where     = $params['where'];
        $array     = $params['array'];

        return DbCore::getValue(
            "SELECT count($fieldName) FROM `$tableName` WHERE $where",
            $array
        );
    }
    /**
     * Get values from one tables column
     * @param array $params
     * @return array // array or []
     */
    public function getColumn(array $params): array
    {
        $tableName        = $params['table_name'];
        $fieldName        = $params['field_name'];
        $where            = $params['where'];
        $orderByFieldName = $params['order_by_field_name'];
        $orderByDirection = $params['order_by_direction'];
        $offset           = $params['offset'];
        $limit            = $params['limit'];
        $array            = $params['array'];
        $setLimit         = $limit == 0 ? '' : "LIMIT $offset, $limit";

        $query = "SELECT $fieldName FROM $tableName
            WHERE $where
            ORDER BY $orderByFieldName $orderByDirection
            $setLimit";

        return DbCore::getColumn($query, $array);
    }

    private function __clone() {}
    public function __wakeup() {}
}
