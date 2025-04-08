<?php

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Plugins\ParamsToSql;
use Core\Auth;
use Core\Plugins\Model\DB;

class SaveItemEditLogCopy extends Item
{
    private static $instance = null;
    private $fieldsNoSaveToLog = null;

    private function __construct() {}
    #
    public static function getI(): SaveItemEditLogCopy
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Save items edit log
     * @param string $fieldName
     * @param string $value
     * @return boolean
     */
    public function saveItemEditLog(string $fieldName, string $value): bool
    {
        /**
         * Save to items edit log
         */
        $return = DB::getI()->add(
            [
                'table_name' => 'item_edit_log',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'item_controller_id' => $this->checkItem()['item_controller_id'],
                        'item_id'            => $this->checkItem()['id'],
                        'editor_id'          => Auth::getUserId(),
                        'edited_field'       => $fieldName,
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
     * Return …
     * @return array
     */
    private function fieldsNoSaveToLog(): array
    {
        if ($this->fieldsNoSaveToLog == null) {
            $this->fieldsNoSaveToLog = require 'src' . DS . 'inc' . DS . 'item' . DS . 'noSaveToLog.php';
        }

        return $this->fieldsNoSaveToLog;
    }
    #
    #
    private function __clone() {}
    #
    public function __wakeup() {}
}
