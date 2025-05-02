<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Item\Control\Func;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Plugins\Item\Control\Func;
use Core\Plugins\Item\Filters\Filters;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\DB as CoreDB;
use Core\Session;

class GetItemsLang
{
    private static $instance = null;
    private $getItems        = null;
    private $getItemsLang    = null;

    private function __construct() {}

    public static function getI(): GetItemsLang
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return items list in array or []
     * @return array
     */
    private function getItems(): array
    {
        if ($this->getItems === null) {

            $this->getItems = [];

            if (Func::getI()->itemCount() > 0) {

                $orderBy = Filters::getI()->orderBy();

                $fields = [];

                foreach (Item::getI()->itemParams()['fields_in_body'] as $key => $value) {
                    if (in_array($value, Item::getI()->getAllItemFields()['default'])) {
                        $fields['item'][] = $value;
                    } elseif (in_array($value, Item::getI()->getAllItemFields()['filters'])) {
                        $fields['filters'][] = $value;
                    } elseif (in_array($value, Item::getI()->getAllItemFields()['fieldset'])) {
                        $fields['fieldset'][] = $value;
                    }
                }
                unset($key, $value);

                $getFields = '';

                if (
                    isset($fields['item']) &&
                    $fields['item'][0] != 'id'
                ) {
                    array_unshift($fields['item'], 'id');
                }

                if (
                    isset($fields['filters']) ||
                    isset($fields['fieldset'])
                ) {
                    foreach ($fields['item'] as $key => $value) {
                        $getFields .= $value == 'id' ? 'item.id AS item_id, ' : 'item.' . $value . ', ';
                    }
                    unset($key, $value);
                    $whereId = 'item.id';
                    $toOrder = 'item_id';
                } else {
                    foreach ($fields['item'] as $key => $value) {
                        $getFields .= $value . ', ';
                    }
                    unset($key, $value);
                    $whereId = 'id';
                    $toOrder = 'id';
                }

                if (isset($fields['filters'])) {
                    $filtersTable = 'item_' . Item::getI()->currControllerName();
                    foreach ($fields['filters'] as $key => $value) {
                        $getFields .= $filtersTable . '.' . $value . ', ';
                    }
                    unset($key, $value);
                }

                $getFields = substr($getFields, 0, -2);

                $tables = '';
                $tables = isset($fields['item']) ? $tables . 'item' : $tables;
                $tables = isset($fields['filters']) ? $tables . ' INNER JOIN ' . $filtersTable . ' ON item.id = ' . $filtersTable . '.item_id' : $tables;

                $in      = ParamsToSql::getInSql(Func::getI()->getAllItemsId());
                $inIn    = $in['in'];
                $inArray = $in['array'];

                $query = "SELECT $getFields
                                FROM $tables
                                WHERE $whereId $inIn
                                ";

                $array = $inArray;

                $item = CoreDB::getAll($query, $array);

                foreach ($item as $key => $value) {
                    if (isset($item[$key]['item_id'])) {
                        $item[$key]['id'] = $item[$key]['item_id'];
                        unset($item[$key]['item_id']);
                    }
                }
                unset($key, $value);

                if (isset($fields['fieldset'])) {

                    $fieldset = [];

                    foreach ($fields['fieldset'] as $key => $value) {

                        $fieldset[$value] = DB::getI()->getNeededField(
                            [
                                'table_name'          => 'item_' . $value,
                                'field_name'          => 'item_id`,`' . $value,
                                'where'               => '`item_id`' . $inIn,
                                'array'               => $inArray,
                                'order_by_field_name' => 'item_id',
                                'order_by_direction'  => 'ASC',
                                'offset'              => 0,
                                'limit'               => 0,
                            ]
                        );
                    }
                    unset($key, $value);

                    foreach ($item as $itemKey => $itemValue) {
                        foreach ($fieldset as $fieldsetName => $fieldsetValue) {
                            foreach ($fieldsetValue as $key => $value) {

                                if (
                                    (int) $item[$itemKey]['id'] === (int) $fieldsetValue[$key]['item_id']
                                ) {

                                    $item[$itemKey][$fieldsetName][] = $fieldsetValue[$key][$fieldsetName];
                                    #
                                }
                            }
                        }
                    }
                    unset($itemKey, $itemValue, $fieldset, $fieldsetName, $fieldsetValue, $key, $value);
                }

                $this->getItems = $item;
            }
        }

        return $this->getItems;
    }
    /**
     * Return in array items from table `item-lang` or empty array ([])
     * @return array
     */
    public function getItemsLang(): array
    {
        if ($this->getItemsLang === null) {

            if (Func::getI()->itemCount() > 0) {
                /**
                 * Get items ID
                 */
                $itemsIdList = Func::getI()->getAllItemsId();
                $in          = ParamsToSql::getInSql($itemsIdList);
                $inIn        = $in['in'];
                $inArray     = $in['array'];
                /**
                 * Get default items language
                 */
                $itemsDefLang = DB::getI()->getNeededItemField(
                    [
                        'table_name'          => 'item',
                        'field_name'          => 'id, def_lang',
                        'where'               => 'id' . $inIn,
                        'array'               => $inArray,
                    ]
                );
                /**
                 * Get items content in current language
                 */
                /**
                 * Prepare language fields
                 */
                $langFieldsSql = '';

                if (Item::getI()->itemParams()['lang_fields'] != []) {
                    $variable = Item::getI()->itemParams()['lang_fields'];
                    foreach ($variable as $key => $value) {
                        $langFieldsSql .= ', ' . $value;
                    }
                    unset($variable, $key, $value);
                }
                /**
                 * Get items values in currently language
                 */
                $itemsCurLang = DB::getI()->getNeededItemField(
                    [
                        'table_name'          => 'item_lang',
                        'field_name'          => 'item_id' . $langFieldsSql,
                        'where'               => 'item_id' . $inIn . ' AND cur_lang = :cur_lang',
                        'array'               => array_merge($inArray, ['cur_lang' => Session::getLang()]),
                    ]
                );

                $itemsLangsValue = [];
                $defLang         = [];
                /**
                 * Sorted items by correctly orders
                 */
                foreach ($itemsIdList as $key => $itemId) {
                    foreach ($itemsDefLang as $defLangKey => $defLangValue) {
                        if ((int) $itemId === (int) $defLangValue['id']) {
                            unset($defLangValue['id']);
                            $itemsLangsValue[$itemId] = $defLangValue;
                            $defLang[$itemId] = $defLangValue['def_lang'];
                            unset($itemsDefLang[$defLangKey]);
                            break;
                        }
                    }
                }
                unset($key, $itemId, $defLangKey, $defLangValue, $itemsDefLang);
                /**
                 * Save to item currently language values
                 */
                foreach ($itemsLangsValue as $itemId => $itemValue) {
                    foreach ($itemsCurLang as $curLangKey => $curLangValue) {
                        if ((int) $itemId === (int) $curLangValue['item_id']) {
                            unset($curLangValue['item_id'], $defLang[$itemId]);
                            $itemsLangsValue[$itemId] = $curLangValue;
                            unset($itemsCurLang[$curLangKey]);
                            break;
                        }
                    }
                }
                unset($itemId, $itemValue, $curLangKey, $curLangValue, $itemsCurLang);
                /**
                 * If not currently languages values to all items
                 */
                if ($defLang != []) {

                    $otherLang = [];

                    foreach ($defLang as $itemId => $itemDefLang) {
                        $otherLang[$itemDefLang][] = $itemId;
                    }
                    unset($defLang, $itemId, $itemDefLang);
                    /**
                     * Get needed default items language content
                     */
                    foreach ($otherLang as $lang => $itemsId) {
                        /**
                         * Set items id to sql
                         */
                        $in          = [];
                        $langContent = [];

                        $in      = ParamsToSql::getInSql($itemsId);
                        $inIn    = $in['in'];
                        $inArray = $in['array'];
                        /**
                         * Get items values in currently language
                         */
                        $langContent = DB::getI()->getNeededItemField(
                            [
                                'table_name'          => 'item_lang',
                                'field_name'          => 'item_id' . $langFieldsSql,
                                'where'               => 'item_id' . $inIn . ' AND cur_lang = :cur_lang',
                                'array'               => array_merge($inArray, ['cur_lang' => $lang]),
                            ]
                        );

                        foreach ($itemsLangsValue as $itemId => $itemValue) {
                            foreach ($langContent as $curLangKey => $curLangValue) {
                                if ((int) $itemId === (int) $curLangValue['item_id']) {
                                    unset($curLangValue['item_id']);
                                    $itemsLangsValue[$itemId] = $curLangValue;
                                    unset($langContent[$curLangKey]);
                                    break;
                                }
                            }
                        }
                        unset($itemId, $itemValue, $curLangKey, $curLangValue, $langContent);
                    }
                    unset($otherLang, $lang, $itemsId);
                }

                $allItems = $this->getItems();

                foreach ($itemsLangsValue as $itemId => $langContent) {
                    foreach ($allItems as $itemsKey => $itemsValue) {
                        if (
                            (int) $itemId === (int) $itemsValue['id']
                        ) {
                            $itemsLangsValue[$itemId] = array_merge($allItems[$itemsKey], $langContent);
                            unset($allItems[$itemsKey]);
                            break;
                        }
                    }
                }
                unset($itemId, $langContent, $allItems, $itemsKey, $itemsValue);

                $this->getItemsLang = $itemsLangsValue;
                #
            } else {
                $this->getItemsLang = [];
            }
        }

        return $this->getItemsLang;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
