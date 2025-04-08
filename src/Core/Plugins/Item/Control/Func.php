<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item\Control;

defined('AIW_CMS') or die;

use Core\DB as CoreDB;
use Core\Modules\Pagination\Pagination;
use Core\Plugins\Check\{Extra, Item};
use Core\Plugins\Item\Filters\Filters;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Tpl;
use Core\Plugins\Item\Control\Func\GetItemsLang;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $itemCount       = null;
    private $getAllItemsId   = null;
    private $prepareSql      = null;
    private $prepareLimit    = 'null';
    private $prepareOrderBy  = 'null';
    private $getContent      = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return user access
     * @return bool
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Item::getI()->itemParams()['access'] === true
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Return prepared SQL
     * @return string
     */
    private function prepareSql(): array
    {
        if ($this->prepareSql == null) {

            $tables  = '';
            $whereId = '';
            $where   = '';
            $array   = [];
            /**
             * If isset EXTRA values
             */
            if (isset(Filters::getI()->getFiltersValues()['extra'])) {

                $extra = Extra::extraItem(Filters::getI()->getFiltersValues()['extra']);

                $tables  = $extra['tables'];
                $whereId = $extra['where_id'];
                $where   = $extra['where'];
                $array   = $extra['array'];
            }

            $filtersValues = $this->checkFieldsType(Filters::getI()->getFiltersValues());
            /**
             * If isset ITEM fields
             */
            if (isset($filtersValues['itemFields'])) {
                $where .= ParamsToSql::getSqlToTable($filtersValues['itemFields'], 'item') . ' AND ';
                $array  = array_merge($array, $filtersValues['itemFields']);
            }
            /**
             * If isset FILTERS fields
             */
            if (isset($filtersValues['filtersFields'])) {

                $filtersTable = 'item_' . Item::getI()->currControllerName();

                $tables .= ', ' . $filtersTable;
                $whereId .= 'item.id = ' . $filtersTable . '.item_id AND ';
                $where .= ParamsToSql::getSqlToTable($filtersValues['filtersFields'], $filtersTable) . ' AND ';
                $array  = array_merge($array, $filtersValues['filtersFields']);
                #
            }
            /**
             * If isset FIELDSET fields
             */
            if (isset($filtersValues['fieldsetFields'])) {

                $fieldsetFields = $filtersValues['fieldsetFields'];

                foreach ($fieldsetFields as $fieldsetName => $fieldsetArray) {

                    if (is_array($fieldsetArray)) {

                        $fieldset = [];

                        $fieldsetTable = 'item_' . $fieldsetName;

                        $tables  .= ', ' . $fieldsetTable;
                        $whereId .= 'item.id = ' . $fieldsetTable . '.item_id AND ';

                        $fieldset = ParamsToSql::getInSql($fieldsetArray, 'IN', $fieldsetName);

                        $where .= $fieldsetTable . '.' . $fieldsetName . $fieldset['in'] . ' AND ';
                        $array  = array_merge($array, $fieldset['array']);
                        #
                    }
                }
                unset($fieldsetName, $fieldsetArray);
            }

            $where = $where == '' ? '' : 'AND ' . substr($where, 0, -5);

            $array = array_merge($array, ['item_controller_id' => Item::getI()->currControllerId()]);

            $this->prepareSql['tables']  = $tables;
            $this->prepareSql['idWhere'] = $whereId;
            $this->prepareSql['where']   = $where;
            $this->prepareSql['orderBy'] = $this->prepareOrderBy();
            $this->prepareSql['array']   = $array;
        }

        return $this->prepareSql;
    }
    /**
     * Return prepared ORDER BY value to SQL
     * @return string
     */
    public function prepareOrderBy(): string
    {
        if ($this->prepareOrderBy == 'null') {

            if (
                isset(Item::getI()->itemParams()['self_order_by']) &&
                Item::getI()->itemParams()['self_order_by'] === true
            ) {
                $this->prepareOrderBy = 'item.self_order ASC, item.id ' . Filters::getI()->orderBy();
            } else {
                $this->prepareOrderBy = 'item.id ' . Filters::getI()->orderBy();
            }
        }

        return $this->prepareOrderBy;
    }
    #
    /**
     * Return SQL limit items data from database
     * @return string
     */
    private function prepareLimit(): string
    {
        if ($this->prepareLimit == 'null') {

            if (
                $this->itemCount() <= Item::getI()->itemParams()['pagination']
            ) {

                $this->prepareLimit = '';
                #
            } elseif (
                Pagination::checkStartGet() >= $this->itemCount()
            ) {

                $this->prepareLimit = 'LIMIT 0, ' . Item::getI()->itemParams()['pagination'];
                #
            } else {

                $this->prepareLimit = 'LIMIT ' . Pagination::checkStartGet() . ', ' . Item::getI()->itemParams()['pagination'];
                #
            }
        }

        return $this->prepareLimit;
    }
    /**
     * Return count all items id
     * @return int // int or 0
     */
    public function itemCount(): int
    {
        if ($this->itemCount === null) {

            $tables  = $this->prepareSql()['tables'];
            $idWhere = $this->prepareSql()['idWhere'];
            $where   = $this->prepareSql()['where'];
            $array   = (array) $this->prepareSql()['array'];

            $query = "SELECT COUNT(item.id)
                FROM item $tables
                WHERE $idWhere
                item.item_controller_id = :item_controller_id
                $where";

            $return = CoreDB::getFromManyTable(
                $query,
                $array
            );

            if ($return != []) {
                $this->itemCount = array_key_first($return);
            } else {
                $this->itemCount = 0;
            }
        }

        return $this->itemCount;
    }
    /**
     * Return all items id
     * @return array // array
     */
    public function getAllItemsId(): array
    {
        if ($this->getAllItemsId === null) {

            $tables  = $this->prepareSql()['tables'];
            $idWhere = $this->prepareSql()['idWhere'];
            $where   = $this->prepareSql()['where'];
            $orderBy = $this->prepareSql()['orderBy'];
            $array   = (array) $this->prepareSql()['array'];
            $limit   = $this->prepareLimit();

            $query = "SELECT item.id
                FROM item $tables
                WHERE $idWhere
                item.item_controller_id = :item_controller_id
                $where
                ORDER BY $orderBy $limit";

            $return = CoreDB::getFromManyTable(
                $query,
                $array
            );

            if ($return != []) {
                $idList = [];
                foreach ($return as $key => $value) {
                    $idList[] = $key;
                }
                unset($key, $value, $return);

                $this->getAllItemsId = $idList;
            } else {
                $this->getAllItemsId = [];
            }
        }

        return $this->getAllItemsId;
    }
    /**
     * Return all items values to page render
     * @return array
     */
    public function getContent(): array
    {
        if ($this->getContent === null) {

            $this->getContent = Item::getI()->itemParams();

            $this->getContent['content'] .= Filters::getI()->viewFiltersForm();

            $this->getContent['content'] .= Tpl::view(
                Item::getI()->itemParams()['template_path'],
                [
                    'count'          => $this->itemCount(),
                    'paginationStep' => Item::getI()->itemParams()['pagination'],
                    'header'         => Tpl::view(Item::getI()->itemParams()['header_path']),
                    'body'           => $this->body(),
                ]
            );
        }

        return $this->getContent;
    }
    /**
     * Get controls page items body
     * @return string
     */
    private function body(): string
    {
        $itemsLang = GetItemsLang::getI()->getItemsLang();

        $body = '';

        if ($itemsLang != []) {

            foreach ($itemsLang as $key => $value) {

                foreach ($itemsLang[$key] as $fieldName => $fieldValue) {
                    $v[$fieldName] = $fieldValue;
                }

                $body .= Tpl::view(Item::getI()->itemParams()['body_path'], $v);
            }
            unset($key, $value, $key1, $value1);
        }

        return $body;
    }
    /**
     * Check items filters fields type
     * @param array $filtersValues
     * @return array
     */
    public function checkFieldsType(array $filtersValues): array
    {
        $fieldsList = [];

        $defaultFields  = array_flip(Item::getI()->getAllItemFields()['default']);
        $langFields     = array_flip(Item::getI()->getAllItemFields()['lang']);
        $filtersFields  = array_flip(Item::getI()->getAllItemFields()['filters']);
        $fieldsetFields = array_flip(Item::getI()->getAllItemFields()['fieldset']);

        foreach ($filtersValues as $key => $value) {

            $keyOk = str_replace(['_from', '_to'], '', $key);

            if (isset($defaultFields[$keyOk])) {
                $fieldsList['itemFields'][$key] = $value;
            } elseif (isset($langFields[$keyOk])) {
                $fieldsList['langFields'][$key] = $value;
            } elseif (isset($filtersFields[$keyOk])) {
                $fieldsList['filtersFields'][$key] = $value;
            } elseif (isset($fieldsetFields[$keyOk])) {
                $fieldsList['fieldsetFields'][$key] = $value;
            } else {
                continue;
            }
        }
        unset($key, $value);

        return $fieldsList;
    }

    private function __clone() {}
    public function __wakeup() {}
}
