<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\ParamsToSql;
use Core\Plugins\Check\Item;
use Core\Plugins\Model\DB;

class SaveItemEditLog
{
    private static $fieldsNoSaveToLog = null;
    /**
     * Save items edit log
     * @param string $fieldName
     * @param string|array $value
     * @return boolean
     */
    public static function saveItemEditLog(string $fieldName, mixed $value): bool
    {
        /**
         * Save to items edit log
         */
        if (isset(self::fieldsNoSaveToLog()[$fieldName])) {

            $oldValue = '*** old value ***';
            $newValue = '*** new value ***';
            #
        } elseif (is_array(Item::getI()->checkItem()[$fieldName])) {

            $oldValue = trim(implode(",", Item::getI()->checkItem()[$fieldName]), ",");
            $newValue = $value;
            #
        } else {

            $oldValue = Item::getI()->checkItem()[$fieldName];
            $newValue = $value;
            #
        }

        $return = DB::getI()->add(
            [
                'table_name' => 'item_edit_log',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'item_controller_id' => Item::getI()->checkItem()['item_controller_id'],
                        'item_id'            => Item::getI()->checkItem()['item_id'],
                        'editor_id'          => Auth::getUserId(),
                        'edited_field'       => $fieldName,
                        'old_value'          => $oldValue,
                        'new_value'          => $newValue,
                        'edited'             => time(),
                    ]
                ),
                'array'      => $set,
            ]
        );

        if ($return > 0) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }
    /**
     * Return in array field name his not values save to log table
     * @return array
     */
    private static function fieldsNoSaveToLog(): array
    {
        if (self::$fieldsNoSaveToLog == null) {
            self::$fieldsNoSaveToLog = require PATH_INC . 'item' . DS . 'noSaveToLog.php';
        }

        return self::$fieldsNoSaveToLog;
    }
    #
    private function __clone() {}
    #
    public function __wakeup() {}
}
