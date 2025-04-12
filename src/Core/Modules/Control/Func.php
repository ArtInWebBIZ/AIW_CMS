<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\Control;

defined('AIW_CMS') or die;

use Core\{Clean, Config, GV, Session, Router};
use Core\Modules\Control\Filters\Filters;
use Core\Modules\Pagination\Pagination;
use Core\Plugins\{Dll\FiltersNote, ParamsToSql, Model\DB, View\Tpl};

class Func
{
    private static $instance    = null;
    private $params             = [];
    private $getFiltersValues   = [];
    private $getNeededId        = null;
    private $getItemsListHtml   = 'null';
    private $countItemsId       = 'null';
    private $viewItemsList      = [];
    private $filtersValuesToSql = [];
    private $checkAccess        = 'null';
    private $curDir             = null;
    private $orderBy            = 'null';
    private $getAllItems        = null;

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

            $this->params             = [];
            $this->getFiltersValues   = [];
            $this->getNeededId        = null;
            $this->getItemsListHtml   = 'null';
            $this->countItemsId       = 'null';
            $this->viewItemsList      = [];
            $this->filtersValuesToSql = [];
            $this->curDir             = $dirName;
            $this->orderBy            = 'null';
            $this->getAllItems        = null;

            $this->checkAccess = false;

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
        if ($this->params === []) {

            $dir = $dirName === null ? '' : $dirName . DS;

            $this->params = require PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . $dir . 'params.php';
            #
        }

        return $this->params;
    }
    /**
     * Delete old filters note
     * @return boolean
     */
    public function deleteOldFiltersNote(): bool
    {
        return FiltersNote::getI()->deleteOldFiltersNote();
    }
    /**
     * Count items
     * @return integer
     */
    public function countItemsId(): int
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
    /**
     * Get in array in key ['content'] control template and insert to
     * template needed values,
     * or view in key ['msg'] error message
     * @return array
     */
    public function viewItemsList(): array
    {
        if ($this->viewItemsList === []) {

            if (isset($this->getFiltersValues()['msg'])) {
                $this->viewItemsList['msg'] = $this->getFiltersValues()['msg'];
            } else {

                if ($this->curDir === null) {
                    $controlBody = $this->countItemsId() == 0 ?
                        Tpl::view(PATH_INC . 'content' . DS . 'noResult.php') :
                        $this->getItemsListHtml();
                } else {
                    $controlBody = $this->countItemsId() == 0 ? '' : $this->getItemsListHtml();
                }

                $v = [
                    'title'          => isset($this->getParams()['title']) ? $this->getParams()['title'] : '',
                    'section_css'    => isset($this->getParams()['section_css']) ? $this->getParams()['section_css'] : 'content-section',
                    'container_css'  => isset($this->getParams()['container_css']) ? $this->getParams()['container_css'] : 'uk-container-xlarge uk-background-default uk-padding',
                    'item_heading'   => isset($this->getParams()['item_heading']) ? $this->getParams()['item_heading'] : '',
                    'count'          => $this->countItemsId(),
                    'paginationStep' => isset($this->getParams()['paginationStep']) ? $this->getParams()['paginationStep'] : Config::getCfg('CFG_HISTORY_PAGINATION'),
                    'control_header' => $this->getParams()['control_header'] == '' ? '' : Tpl::view($this->getParams()['control_header']),
                    'control_body'   => $controlBody,
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
    /**
     * Return in string all control items
     * @return string
     */
    private function getItemsListHtml(): string
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
                unset($key1, $value1, $key2, $value2);
                #
            }

            $this->getItemsListHtml = $itemsBodyHtml;
        }

        return $this->getItemsListHtml;
    }
    /**
     * Return ORDER BY params for sql
     * @return string
     */
    public function orderBy(): string
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
    /**
     * Return in array all items value or empty array
     * @return array
     */
    public function getAllItems(): array
    {
        if ($this->getAllItems === null) {

            if ($this->getNeededId() !== []) {

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
                #
            } else {
                $this->getAllItems = [];
            }
        }

        return $this->getAllItems;
    }
    /**
     * Get in array list items id or empty array
     * @return array
     */
    private function getNeededId(): array
    {
        if ($this->getNeededId === null) {

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

            if ($getNeededId !== []) {
                for ($i = 0; $i < count($getNeededId); $i++) {
                    $this->getNeededId[$i] = $getNeededId[$i]['id'];
                }
            } else {
                $this->getNeededId = [];
            }
        }

        return $this->getNeededId;
    }
    /**
     * Return correctly prepare sql
     * In key ['sql'] - sql string,
     * in key ['array'] - array to sql
     * @return array
     */
    public function filtersValuesToSql(): array
    {
        if ($this->filtersValuesToSql === []) {
            $this->filtersValuesToSql = Filters::getI()->filtersValuesToSql();
        }

        return $this->filtersValuesToSql;
    }
    /**
     * Get values from filters
     * @return array|null
     */
    public function getFiltersValues(): array|null
    {
        if ($this->getFiltersValues === []) {
            $this->getFiltersValues = Filters::getI()->getFiltersValues();
        }

        return $this->getFiltersValues;
    }
    /**
     * Return correctly filters values from $_GET
     * @return array|boolean
     */
    public function fromGetToPost(): array|bool
    {
        if (GV::get() !== null) {

            $get = GV::get();

            $params = [];

            foreach ($get as $key => $value) {

                if (
                    is_int(Clean::unsInt($get[$key])) &&
                    array_search($key, $this->getParams()['fields_in_body']) !== false
                ) {
                    $params[$key] = Clean::unsInt($get[$key]);
                } else {
                    continue;
                }
            }
            unset($key, $value);

            return $params !== [] ? $params : false;
            #
        } else {
            return false;
        }
    }
    /**
     * Save currently filters parameters to filters note
     * @param array $getFiltersValues
     * @return integer
     */
    public function saveNote(array $getFiltersValues): int
    {
        return DB::getI()->add(
            [
                'table_name' => 'filter_value_note',
                'set'        => ParamsToSql::getSet(
                    $where = [
                        'token'           => Session::getToken(),
                        'controller_name' => Router::getRoute()['controller_name'],
                        'action_name'     => Router::getRoute()['action_name'],
                        'post_note'       => json_encode($getFiltersValues),
                        'enabled_to'      => time() + Config::getCfg('CFG_NOTE_ENABLED_TO'),
                    ]
                ),
                'array'      => $where,
            ]
        );
    }
    /**
     * Update filters note - save new filters values
     * @param array $getFiltersValues
     * @return boolean
     */
    public function updateNote(array $getFiltersValues): bool
    {
        return DB::getI()->update(
            [
                'table_name' => 'filter_value_note',
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

    private function __clone() {}
    public function __wakeup() {}
}
