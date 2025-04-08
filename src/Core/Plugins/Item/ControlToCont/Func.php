<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item\ControlToCont;

defined('AIW_CMS') or die;

use Core\Config;
use Core\DB as CoreDB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Tpl;
use Core\Plugins\Model\DB;
use Core\Router;
use Core\Plugins\Item\ControlToCont\GetItemsLang;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $itemCount       = null;
    private $getAllItemsId   = null;
    private $prepareSql      = null;
    private $prepareOrderBy  = 'null';
    private $itemParams      = [];
    private $curDir          = null;

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
    public function checkAccess(string $dirName = null): bool
    {
        if (
            $this->checkAccess == 'null' ||
            $this->curDir !== $dirName
        ) {

            $this->curDir   = $dirName;

            $this->itemCount      = null;
            $this->getAllItemsId  = null;
            $this->prepareSql     = null;
            $this->prepareOrderBy = 'null';
            $this->itemParams     = [];

            $this->checkAccess = false;

            if (
                isset($this->itemParams($dirName)['access']) &&
                $this->itemParams($dirName)['access'] === true
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Return …
     * @return array|bool
     */
    public function itemParams(string $dirName = null): array|bool
    {
        if ($this->itemParams === []) {

            $dir = $dirName === null ? '' : $dirName . DS;

            $path = PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . $dir . 'itemParams.php';

            if (file_exists($path)) {
                $itemParams = require $path;
            } else {
                $itemParams = false;
            }

            $this->itemParams = $itemParams;
        }

        return $this->itemParams;
    }
    #
    /**
     * Return …
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
            if (isset($this->itemParams()['extra'])) {

                $extra = Extra::extraItem($this->itemParams()['extra'], $this->curDir);

                $tables  = $extra['tables'];
                $whereId = $extra['where_id'];
                $where   = $extra['where'];
                $array   = $extra['array'];

                if (
                    isset($this->itemParams()['extra']['id']) &&
                    is_array($this->itemParams()['extra']['id']['value'])
                ) {
                    $this->prepareSql['orderBy'] = '';
                }
            }

            $where = $where == '' ? '' : 'AND ' . substr($where, 0, -5);

            $array = array_merge($array, ['item_controller_id' => $this->getCurControllerId()]);

            $this->prepareSql['tables']  = $tables;
            $this->prepareSql['idWhere'] = $whereId;
            $this->prepareSql['where']   = $where;
            $this->prepareSql['orderBy'] = isset($this->prepareSql['orderBy']) ? $this->prepareSql['orderBy'] : 'ORDER BY ' . $this->prepareOrderBy();
            $this->prepareSql['array']   = $array;
        }

        return $this->prepareSql;
    }
    /**
     * Return …
     * @return string
     */
    public function prepareOrderBy(): string
    {
        if ($this->prepareOrderBy == 'null') {

            if (
                isset($this->itemParams()['self_order_by']) &&
                $this->itemParams()['self_order_by'] === true
            ) {
                $this->prepareOrderBy = 'item.self_order ASC, item.id ' . $this->itemParams()['order_by'];
            } else {
                $this->prepareOrderBy = 'item.id ' . $this->itemParams()['order_by'];
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
        if (isset($this->itemParams()['extra_limit'])) {

            $prepareLimit = 'LIMIT 0, ' . $this->itemParams()['extra_limit'];
            #
        } elseif (isset($this->itemParams()['pagination'])) {

            $prepareLimit = 'LIMIT 0, ' . $this->itemParams()['pagination'];
            #
        } else {

            $prepareLimit = 'LIMIT 0, ' . Config::getCfg('CFG_PAGINATION');
            #
        }

        return $prepareLimit;
    }
    /**
     * Return all items id count
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
     * Return all items id in array or empty array []
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
                    $where $orderBy $limit";

            $return = CoreDB::getFromManyTable(
                $query,
                $array
            );

            if ($return != []) {

                $idList = [];

                if (
                    isset($this->itemParams()['extra']['id']['value']) &&
                    is_array($this->itemParams()['extra']['id']['value'])
                ) {

                    $variable = $this->itemParams()['extra']['id']['value'];

                    foreach ($variable as $key => $itemId) {
                        if (isset($return[$itemId])) {
                            $idList[] = $itemId;
                            unset($return[$itemId]);
                        }
                    }
                    unset($key, $itemId, $variable, $return);
                    #
                } else {

                    foreach ($return as $key => $value) {
                        $idList[] = $key;
                    }
                    unset($key, $value, $return);
                }

                $this->getAllItemsId = $idList;
                #
            } else {
                $this->getAllItemsId = [];
            }
        }

        return $this->getAllItemsId;
    }
    /**
     * Return …
     * @return array
     */
    public function getContent(): array
    {
        $getContent = [];

        if (is_array($this->itemParams())) {

            $getContent = $this->itemParams();

            if (
                isset($this->itemParams()['template_path']) &&
                file_exists($this->itemParams()['template_path'])
            ) {

                if ($this->itemCount() > 0) {

                    $getContent['content'] = Tpl::view(
                        $this->itemParams()['template_path'],
                        [
                            'count'          => $this->itemCount(),
                            'paginationStep' => $this->itemParams()['pagination'],
                            'header'         => Tpl::view($this->itemParams()['header_path']),
                            'body'           => $this->body(),
                        ]
                    );
                    #
                } else {
                    $getContent['content'] = '';
                }
            }
        }

        return $getContent === [] ? $getContent['content'] = '' : $getContent;
    }
    /**
     * Get controls page body
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

                $body .= Tpl::view($this->itemParams()['body_path'], $v);
            }
            unset($key, $value, $key1, $value1);
        }

        return $body;
    }
    /**
     * @return mixed // value or null
     */
    private function getCurControllerId()
    {
        return DB::getI()->getValue(
            [
                'table_name' => 'item_controller',
                'select'     => 'id',
                'where'      => ParamsToSql::getSql(
                    $where = ['controller_url' => $this->itemParams()['controller_url']]
                ),
                'array'      => $where,
            ]
        );
    }

    public function getCurDir()
    {
        return $this->curDir;
    }

    private function __clone() {}
    public function __wakeup() {}
}
