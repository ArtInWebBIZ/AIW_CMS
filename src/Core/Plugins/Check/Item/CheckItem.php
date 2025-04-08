<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Plugins\Check\IntPageAlias;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Session;

class CheckItem
{
    private static $checkItem = null;
    /**
     * Return items array or false
     * @return mixed // array or false
     */
    public static function checkItem(): array|bool
    {
        if (self::$checkItem === null) {
            /**
             * Set default function value
             */
            $checkItem = false;
            /**
             * Get corrected item ID from page alias
             */
            $itemId = is_int(IntPageAlias::check()) ? IntPageAlias::check() : false;
            /**
             * If correct item ID 
             */
            if ($itemId != false) {
                /**
                 * Get in array core item values
                 */
                $checkItem = DB::getI()->getRow(
                    [
                        'table_name' => 'item',
                        'where'      => ParamsToSql::getSql(
                            $where = ['id' => $itemId]
                        ),
                        'array'      => $where,
                    ]
                );

                if (
                    is_array($checkItem) &&
                    (int) $checkItem['item_controller_id'] === Item::getI()->currControllerId()
                ) {
                    /**
                     * Get item values from `item_lang` table
                     */
                    $return = DB::getI()->getRow(
                        [
                            'table_name' => 'item_lang',
                            'where'      => ParamsToSql::getSql(
                                $where = [
                                    'item_id'  => $itemId,
                                    'cur_lang' => Session::getLang()
                                ]
                            ),
                            'array'      => $where,
                        ]
                    );
                    /**
                     * Get default item value
                     */
                    if ($return === false) {

                        $return = DB::getI()->getRow(
                            [
                                'table_name' => 'item_lang',
                                'where'      => ParamsToSql::getSql(
                                    $where = [
                                        'item_id'  => $itemId,
                                        'cur_lang' => $checkItem['def_lang']
                                    ]
                                ),
                                'array'      => $where,
                            ]
                        );
                    }

                    if ($return !== false) {
                        /**
                         * Add new values to item
                         */
                        unset($return['id']);
                        $checkItem = array_merge($checkItem, $return);
                        /**
                         * Get filters values
                         */
                        if (
                            Item::getI()->getAllItemFields()['filters'] != []
                        ) {

                            $return = DB::getI()->getRow(
                                [
                                    'table_name' => 'item_' . Item::getI()->currControllerName(),
                                    'where'      => ParamsToSql::getSql(
                                        $where = ['item_id' => $checkItem['id']]
                                    ),
                                    'array'      => $where,
                                ]
                            );

                            if ($return !== false) {
                                /**
                                 * Add new values to item
                                 */
                                unset($return['id']);
                                $checkItem = array_merge($checkItem, $return);
                                #
                            } else {
                                $checkItem = false;
                            }
                            unset($return);
                        }
                        unset($return);
                        #
                    } else {
                        $checkItem = false;
                    }
                    /**
                     * Get fieldset values
                     */
                    if (
                        $checkItem !== false &&
                        Item::getI()->getAllItemFields()['fieldset'] != []
                    ) {

                        $fieldsetList = Item::getI()->getAllItemFields()['fieldset'];

                        foreach ($fieldsetList as $key => $value) {

                            $return = DB::getI()->getNeededField(
                                [
                                    'table_name'          => 'item_' . $value,
                                    'field_name'          => $value, // example 'id' or 'id`,`edited_count`,`brand_status'
                                    'where'               => ParamsToSql::getSql(
                                        $where = ['item_id' => $checkItem['id']]
                                    ),
                                    'array'               => $where,
                                    'order_by_field_name' => 'id',
                                    'order_by_direction'  => 'ASC', // DESC
                                    'offset'              => 0,
                                    'limit'               => 0, // 0 - unlimited
                                ]
                            );

                            if ($return != []) {

                                foreach ($return as $key1 => $value1) {
                                    $fieldset[$value][] = $return[$key1][$value];
                                }
                            }
                        }

                        unset($return);

                        $checkItem = array_merge($checkItem, $fieldset);
                    }
                    #
                } else {
                    $checkItem = false;
                }
            }

            self::$checkItem = $checkItem;
            #
        }

        return self::$checkItem;
    }
}
