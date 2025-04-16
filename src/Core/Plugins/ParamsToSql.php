<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Router;

class ParamsToSql
{
    public static function getSql(array $params, string $logic = ' AND '): string
    {
        $sql = '';

        foreach ($params as $key => $value) {
            if (stripos($key, "_from") !== false) {
                $sql .= '`' . str_replace("_from", "", $key) . '` >= :' . $key . $logic;
            } elseif (stripos($key, "_to") !== false) {
                $sql .= '`' . str_replace("_to", "", $key) . '` < :' . $key . $logic;
            } else {
                $sql .= '`' . $key . '` = :' . $key . $logic;
            }
        }

        return substr(trim($sql), 0, -4);
    }

    public static function getSqlToTable(array $params, string $tableName, string $logic = ' AND '): string
    {
        $sql = '';

        foreach ($params as $key => $value) {
            if (stripos($key, "_from") !== false) {
                $sql .= $tableName . '.' . str_replace("_from", "", $key) . ' >= :' . $key . $logic;
            } elseif (stripos($key, "_to") !== false) {
                $sql .= $tableName . '.' . str_replace("_to", "", $key) . ' < :' . $key . $logic;
            } elseif (stripos($key, "_start") !== false) {
                $sql .= $tableName . '.' . $key . ' >= :' . $key . $logic;
            } elseif (stripos($key, "_end") !== false) {
                $sql .= $tableName . '.' . $key . ' < :' . $key . $logic;
            } else {
                $sql .= $tableName . '.' . $key . ' = :' . $key . $logic;
            }
        }

        return substr(trim($sql), 0, -4);
    }
    /**
     * Return SQL or ''
     * @param array $params
     * @return string // SQL or ''
     */
    public static function getControlSql(array $params): string
    {
        $sql = '';

        if ($params != []) {

            $itemFields = Item::getI()->getItemFields();
            $filtersTable = 'item_' . str_replace("-", "_", Router::getRoute()['controller_url']);

            foreach ($params as $key => $value) {

                if ($key == 'order_by') {
                    continue;
                } elseif (strpos($key, '_from')) {

                    $clearKey = str_replace("_from", "", $key);

                    if (in_array($clearKey, $itemFields, true)) {
                        $sql .= 'item.' . $clearKey . ' >= :' . $key . ' AND ';
                    } else {
                        $sql .= $filtersTable . '.' . $clearKey . ' >= :' . $key . ' AND ';
                    }
                    #
                } elseif (strpos($key, '_to')) {

                    $clearKey = str_replace("_to", "", $key);

                    if (in_array($clearKey, $itemFields, true)) {
                        $sql .= 'item.' . $clearKey . ' < :' . $key . ' AND ';
                    } else {
                        $sql .= $filtersTable . '.' . $clearKey . ' < :' . $key . ' AND ';
                    }
                    #
                } elseif (in_array($key, $itemFields, true)) {
                    $sql .= 'item.' . $key . ' = :' . $key . ' AND ';
                } else {
                    $sql .= $filtersTable . '.' . $key . ' = :' . $key . ' AND ';
                }
            }

            return substr(trim($sql), 0, -4);
            #
        } else {
            return $sql;
        }
    }

    public static function getSqlOr(array $params): string
    {
        $sql = '';

        foreach ($params as $key => $value) {
            $sql .= '`' . $key . '` = :' . $key . ' OR ';
        }

        return substr(trim($sql), 0, -3);
    }

    public static function getSqlOrTable(array $params, string $tableName): string
    {
        $sql = '';
        $fieldName = str_replace("item_", "", $tableName);

        foreach ($params as $key => $value) {
            $sql .= $tableName . '.' . $fieldName . ' = :' . $fieldName . '_' . $key . ' OR ';
        }

        return substr(trim($sql), 0, -3);
    }

    public static function getSet(array $params): string
    {
        $set = '';

        foreach ($params as $key => $value) {
            $set .= '`' . $key . '` = :' . $key . ', ';
        }

        return substr(trim($set), 0, -1);
    }
    /**
     * Return array adapted to 
     * @param array  $params
     * @param string $inType
     * @return array
     * @key ['in']
     * @key ['array']
     */
    public static function getInSql(array $params, string $inType = 'IN', string $fieldName = 'in'): array
    {
        $out = [];

        foreach ($params as $key => $value) {

            $out['in'][$fieldName . '_' . $key]    = ':' . $fieldName . '_' . $key;
            $out['array'][$fieldName . '_' . $key] = $value;
            #
        }
        unset($key, $value);

        $out['in'] = ' ' . $inType . ' (' . implode(",", $out['in']) . ') ';
        return $out;
    }
}
