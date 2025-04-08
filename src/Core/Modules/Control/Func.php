<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\Control;

defined('AIW_CMS') or die;

use Core\{Clean, Auth, Config, GV, Session, Router};
use Core\Modules\Pagination\Pagination;
use Core\Plugins\{Dll\FiltersNote, ParamsToSql, Model\DB, View\Tpl};

class Func
{
    private static $instance    = null;
    private $params             = [];
    private $getFiltersValues   = [];
    private $getNeededId        = [];
    private $getItemsListHtml   = 'null';
    private $countItemsId       = 'null';
    private $viewItemsList      = [];
    private $filtersValuesToSql = [];
    private $extra              = null;
    private $checkAccess        = 'null';
    private $curDir             = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return access
     * @return boolean
     */
    public function checkAccess($dirName = null): bool
    {
        if (
            $this->checkAccess === 'null' ||
            $this->curDir !== $dirName
        ) {

            $this->curDir = $dirName;

            $this->checkAccess = false;

            $this->params = [];

            if ($this->getParams($dirName)['access'] === true) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    /**
     * Return controllers params
     * @return array
     */
    public function getParams($dirName = null): array
    {
        if ($this->params == []) {

            $dir = $dirName === null ? '' : $dirName . DS;

            $this->params = require PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . $dir . 'params.php';
            #
        }

        return $this->params;
    }

    public function deleteOldFiltersNote()
    {
        return FiltersNote::getI()->deleteOldFiltersNote();
    }


    public function countItemsId()
    {
        if ($this->countItemsId === 'null') {

            if (isset($this->getParams()['extra_limit'])) {

                $this->countItemsId = $this->getParams()['extra_limit'];
                #
            } else {

                $this->countItemsId = (int) DB::getI()->countFields(
                    [
                        'table_name' => $this->getParams()['content_type'],
                        'field_name' => 'id',
                        'where'      => $this->filtersValuesToSql()['sql'],
                        'array'      => $this->filtersValuesToSql()['array'],
                    ]
                );
            }
        }

        return $this->countItemsId;
    }

    public function viewItemsList()
    {
        if ($this->viewItemsList == []) {

            if (isset($this->getFiltersValues()['msg'])) {
                $this->viewItemsList['msg'] = $this->getFiltersValues()['msg'];
            } else {

                $v = [
                    'title'          => isset($this->getParams()['title']) ? $this->getParams()['title'] : '',
                    'section_css'    => isset($this->getParams()['section_css']) ? $this->getParams()['section_css'] : 'content-section',
                    'container_css'  => isset($this->getParams()['container_css']) ? $this->getParams()['container_css'] : 'uk-container-xlarge uk-background-default uk-padding',
                    'item_heading'   => isset($this->getParams()['item_heading']) ? $this->getParams()['item_heading'] : '',
                    'count'          => $this->countItemsId(),
                    'paginationStep' => isset($this->getParams()['paginationStep']) ? $this->getParams()['paginationStep'] : Config::getCfg('CFG_HISTORY_PAGINATION'),
                    'control_header' => $this->getParams()['control_header'] == '' ? '' : Tpl::view($this->getParams()['control_header']),
                    'control_body'   => $this->countItemsId() == 0 ? '' : $this->getItemsListHtml(),
                ];

                if (isset($this->getParams()['template'])) {

                    $this->viewItemsList['content'] = Tpl::view(
                        $this->getParams()['template'], // PATH
                        $v
                    );
                    #
                } else {

                    $this->viewItemsList['content'] = Tpl::view(
                        PATH_MODULES . 'Control' . DS . 'Require' . DS . 'controlTpl.php',
                        $v
                    );
                }
            }
        }

        return $this->viewItemsList;
    }

    private function getItemsListHtml()
    {
        if ($this->getItemsListHtml === 'null') {

            $itemsBodyHtml = '';

            if ($this->getAllItems() != []) {

                foreach ($this->getAllItems() as $key1 => $value1) {

                    foreach ($this->getParams()['fields_in_body'] as $key2 => $value2) {
                        $v[$value2] = $this->getAllItems()[$key1][$value2];
                    }

                    $itemsBodyHtml .= Tpl::view($this->getParams()['control_body'], $v);
                }
                #
            }

            $this->getItemsListHtml = $itemsBodyHtml;
        }

        return $this->getItemsListHtml;
    }

    private $orderBy = 'null';

    public function orderBy()
    {
        if ($this->orderBy == 'null') {

            if (isset(GV::post()['order_by'])) {

                $orderBy = mb_strtoupper(Clean::str(GV::post()['order_by']), 'UTF-8');

                if ($orderBy === 'ASC' || $orderBy === 'DESC') {
                    $this->orderBy = $orderBy;
                } else {
                    $this->orderBy = $this->getParams()['order_by'];
                }
                #
            } elseif (isset($this->getFiltersValues()['order_by'])) {

                $orderBy = $this->getFiltersValues()['order_by'];

                if ($orderBy === 'ASC' || $orderBy === 'DESC') {
                    $this->orderBy = $orderBy;
                } else {
                    $this->orderBy = $this->getParams()['order_by'];
                }
                #
            } else {
                $this->orderBy = $this->getParams()['order_by'];
            }
        }

        return $this->orderBy;
    }

    private $getAllItems = null;

    public function getAllItems(): array
    {
        if ($this->getAllItems == null) {

            $in = ParamsToSql::getInSql($this->getNeededId());

            $this->getAllItems = DB::getI()->getAll(
                [
                    'table_name'          => $this->getParams()['content_type'],
                    'where'               => '`id`' . $in['in'],
                    'array'               => $in['array'],
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => $this->orderBy(),
                    'offset'              => 0,
                    'limit'               => 0,
                ]
            );
        }

        return $this->getAllItems;
    }

    private function getNeededId()
    {
        if ($this->getNeededId === []) {

            if (isset($this->getParams()['extra_limit'])) {
                $limit = $this->getParams()['extra_limit'];
            } elseif (isset($this->getParams()['paginationStep'])) {
                $limit = $this->getParams()['paginationStep'];
            } else {
                $limit = Config::getCfg('CFG_HISTORY_PAGINATION');
            }

            $getNeededId = DB::getI()->getNeededField(
                [
                    'table_name'          => $this->getParams()['content_type'],
                    'field_name'          => 'id',
                    'where'               => $this->filtersValuesToSql()['sql'],
                    'array'               => $this->filtersValuesToSql()['array'],
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => $this->orderBy(),
                    'offset'              => Pagination::checkStartGet() < $this->countItemsId() ? Pagination::checkStartGet() : 0,
                    'limit'               => $limit,
                ]
            );

            for ($i = 0; $i < count($getNeededId); $i++) {
                $this->getNeededId[$i] = $getNeededId[$i]['id'];
            }
        }

        return $this->getNeededId;
    }

    public function filtersValuesToSql()
    {
        if ($this->filtersValuesToSql == []) {

            $filtersValues = $this->getFiltersValues();

            if ($filtersValues !== null) {

                $sql = '';

                foreach ($filtersValues as $key => $value) {

                    if (strpos($key, '_from')) {

                        if (strpos($key, 'created') !== false) {
                            $sql .= '`created` >= :created_from AND ';
                            $array['created_from'] = $value;
                        } elseif (strpos($key, 'edited') !== false) {
                            $sql .= '`edited` >= :edited_from AND ';
                            $array['edited_from'] = $value;
                        } else {
                            $sql .= '`' . $key . '` = :' . $key . ' AND ';
                            $array[$key] = $value;
                        }
                        #
                    } elseif (strpos($key, '_to') !== false) {

                        if (strpos($key, 'created') !== false) {
                            $sql .= '`created` < :created_to AND ';
                            $array['created_to'] = $value;
                        } elseif (strpos($key, 'edited') !== false) {
                            $sql .= '`edited` < :edited_to AND ';
                            $array['edited_to'] = $value;
                        } else {
                            $sql .= '`' . $key . '` = :' . $key . ' AND ';
                            $array[$key] = $value;
                        }
                        #
                    } elseif (strpos($key, 'edited_count') !== false) {

                        if ($value === 0) {
                            $sql .= '`edited_count` = :edited_count AND ';
                            $array['edited_count'] = $value;
                        } else {
                            $sql .= '`edited_count` >= :edited_count AND ';
                            $array['edited_count'] = $value;
                        }
                        #
                    } elseif (strpos($key, 'order_by') !== false) {
                        unset($filtersValues[$key]);
                    } else {
                        $sql .= "`$key` = :$key AND ";
                        $array[$key] = $value;
                    }
                }

                if ($this->extra() != []) {

                    $sql   = $this->extra()['sql'] . $sql;
                    $array = isset($array) ? array_merge($this->extra()['array'], $array) : $this->extra()['array'];
                }

                $sql = substr($sql, 0, -5);

                if ($filtersValues == [] && $this->extra() == []) {
                    $this->filtersValuesToSql['sql']   = '`id` > 0';
                    $this->filtersValuesToSql['array'] = [];
                } else {
                    $this->filtersValuesToSql['sql']   = $sql;
                    $this->filtersValuesToSql['array'] = $array;
                }
                #
            } else {

                if ($this->extra() != []) {
                    $this->filtersValuesToSql['sql']   = substr($this->extra()['sql'], 0, -5);
                    $this->filtersValuesToSql['array'] = $this->extra()['array'];
                } else {
                    $this->filtersValuesToSql['sql']   = '`id` > 0';
                    $this->filtersValuesToSql['array'] = [];
                }
            }
        }

        return $this->filtersValuesToSql;
    }

    public function viewFiltersForm()
    {
        $path = PATH_MODULES . 'Control' . DS . 'FiltersForm' . DS . 'filtersForm.php';

        if ($this->getFiltersValues() !== null) {

            foreach ($this->getFiltersValues() as $key => $value) {

                if (
                    $key != 'paid_to' &&
                    $key != 'paid_from' &&
                    (strpos($key, '_from') !== false ||
                        strpos($key, '_to') !== false
                    )
                ) {
                    $values[$key] = userDate(Config::getCfg('CFG_DATE_TIME_MYSQL_FORMAT'), $value);
                } else {
                    $values[$key] = $value;
                }
            }
        }

        $values['title']               = $this->getParams()['title'];
        $values['filter_fields']       = $this->getParams()['filter_fields'];
        $values['page_link']           = $this->getParams()['page_link'];
        $values['filter_button_label'] = $this->getParams()['filter_button_label'];
        $values['content_type']        = $this->getParams()['content_type'];
        $values['filters_clear_link']  = $this->getParams()['filters_clear_link'];

        return Tpl::view($path, $values);
    }
    /**
     * Get values from filters
     * @return array|null
     */
    public function getFiltersValues(): array|null
    {
        if ($this->getFiltersValues === []) {
            /**
             * Если глобальная переменная POST равна NULL,
             * т.е., из формы переданы данные
             */
            if (GV::post() === null) {
                /**
                 * Ели есть передача из GET в POST
                 */
                if ($this->fromGetToPost() === false) {

                    if (FiltersNote::getI()->getFiltersNote() === false) {

                        $getFiltersValues = null;
                        #
                    } else {

                        $getFiltersValues = json_decode(FiltersNote::getI()->getFiltersNote()['post_note'], true);

                        $this->updateNote($getFiltersValues);
                    }
                    #
                } else {

                    if (FiltersNote::getI()->getFiltersNote() === false) {

                        $getFiltersValues = $this->fromGetToPost();

                        $this->saveNote($getFiltersValues);
                        #
                    } else {

                        $getFiltersValues = json_decode(FiltersNote::getI()->getFiltersNote()['post_note'], true);

                        $fromGetToPost = $this->fromGetToPost();

                        foreach ($getFiltersValues as $key => $value) {

                            if (isset($fromGetToPost[$key])) {
                                $getFiltersValues[$key] = $fromGetToPost[$key];
                                unset($fromGetToPost[$key]);
                            }
                        }

                        $getFiltersValues = array_merge($getFiltersValues, $fromGetToPost);

                        $this->updateNote($getFiltersValues);
                    }
                }
                #
            } else {
                /**
                 * Проверяем поступившие из фильтра данные
                 */
                $getFiltersValues = (new \Core\Plugins\Check\FilterFields)->checkFilterFields(
                    require $this->getParams()['filter_fields']
                );

                if ($getFiltersValues == []) {

                    $getFiltersValues = null;
                    #
                } else {

                    if (FiltersNote::getI()->getFiltersNote() === false) {
                        /** 
                         * Если данные корректны, и нет записи фильтров в БД
                         */
                        $this->saveNote($getFiltersValues);
                        #
                    } else {
                        $this->updateNote($getFiltersValues);
                    }
                }
            }

            $this->getFiltersValues = $getFiltersValues;
        }

        return $this->getFiltersValues;
    }

    private function fromGetToPost()
    {
        if (GV::get() !== null) {

            $get = GV::get();

            $params = [];

            foreach ($get as $key => $value) {

                if (
                    is_int(Clean::int($get[$key])) &&
                    array_search($key, $this->getParams()['fields_in_body']) !== false
                ) {
                    $params[$key] = Clean::int($get[$key]);
                } else {
                    continue;
                }
            }

            return $params !== [] ? $params : false;
            #
        } else {
            return false;
        }
    }

    private function saveNote($getFiltersValues)
    {
        return DB::getI()->add(
            [
                'table_name' => 'control_post_note',
                'set'        => ParamsToSql::getSet(
                    $where = [
                        'token'        => Session::getToken(),
                        'controller_name' => Router::getRoute()['controller_name'],
                        'action_name'  => Router::getRoute()['action_name'],
                        'post_note'    => json_encode($getFiltersValues),
                        'enabled_to'   => time() + Config::getCfg('CFG_NOTE_ENABLED_TO'),
                    ]
                ),
                'array'      => $where,
            ]
        );
    }

    private function updateNote($getFiltersValues)
    {
        return DB::getI()->update(
            [
                'table_name' => 'control_post_note',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'post_note'  => json_encode($getFiltersValues),
                        'enabled_to' => time() + Config::getCfg('CFG_NOTE_ENABLED_TO'),
                    ]
                ),
                'where'      => ParamsToSql::getSql(
                    $where = [
                        'token'           => Session::getToken(),
                        'controller_name' => Router::getRoute()['controller_name'],
                        'action_name'     => Router::getRoute()['action_name'],
                    ]
                ),
                'array'      => array_merge($set, $where),
            ]
        );
    }

    private function extra()
    {
        if ($this->extra === null) {

            $extra = $this->getParams()['extra'];

            if ($extra !== []) {

                $sql = '';

                foreach ($extra as $key => $value) {

                    if (is_array($extra[$key]['filters_values'])) {

                        foreach ($extra[$key]['filters_values'] as $key2 => $value2) {

                            $array[$key2] = $extra[$key]['filters_values'][$key2];
                        }
                    } else {

                        $array[$key] = $extra[$key]['filters_values'];
                    }

                    $sql .= $extra[$key]['sql'];
                }

                $this->extra['sql']   = $sql;
                $this->extra['array'] = $array;
                #
            } else {

                $this->extra = [];
            }
        }

        return $this->extra;
    }

    private $countBalanceReplenishment = 'null';

    public function countBalanceReplenishment()
    {
        if ($this->countBalanceReplenishment == 'null') {

            $where = '`paid_type` = :paid_type AND `edited` > :user_created';
            $array = [
                'paid_type' => 3,
                'user_created' => Auth::getUserCreated(),
            ];

            if (isset($this->getFiltersValues()['edited_from'])) {
                $where = $where . ' AND `edited` > :edited_from';
                $array = array_merge($array, ['edited_from' => $this->getFiltersValues()['edited_from']]);
            }

            if (isset($this->getFiltersValues()['edited_to'])) {
                $where = $where . ' AND `edited` < :edited_to';
                $array = array_merge($array, ['edited_to' => $this->getFiltersValues()['edited_to']]);
            }

            $this->countBalanceReplenishment = DB::getI()->sumFields(
                [
                    'table_name' => 'user_balance_edit_log',
                    'field_name' => 'paid_sum',
                    'where'      => $where,
                    'array'      => $array,
                ]
            );
        }

        return $this->countBalanceReplenishment;
    }

    private function __clone() {}
    public function __wakeup() {}
}
