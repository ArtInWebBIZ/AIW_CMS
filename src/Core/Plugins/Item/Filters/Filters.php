<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item\Filters;

defined('AIW_CMS') or die;

use Core\{Clean, Config, GV, Router, Session, Trl};
use Core\Plugins\Check\Item;
use Core\Plugins\Dll\FiltersNote;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Tpl;

class Filters
{
    private static $instance = null;
    private $getFiltersValues = null;
    private $getFiltersList = null;
    #
    private $orderBy = 'null';

    private function __construct() {}

    public static function getI(): Filters
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return filters values in array or []
     * @return array
     */
    public function getFiltersValues(): array
    {
        if ($this->getFiltersValues === null) {
            /**
             * Delete old notes
             */
            $this->deleteOldNote();
            /**
             * If the global POST variable is NULL,
             */
            if (GV::post() === null) {
                /**
                 * Det values from filters note
                 */
                if (FiltersNote::getI()->getFiltersNote() !== false) {
                    $filtersNote = json_decode(FiltersNote::getI()->getFiltersNote()['post_note'], true);
                } else {
                    $filtersNote = [];
                }
                /**
                 * Create array correct values from $_GET
                 */
                $getOk = [];
                /**
                 * Get values from $_GET
                 */
                if (
                    $this->getFiltersList() != [] &&
                    GV::get() !== null
                ) {

                    $filtersList = $this->getFiltersList();

                    $get = GV::get();

                    if (isset($get['start'])) {
                        unset($get['start']);
                    }
                    /**
                     * If $_GET not empty array
                     */
                    if ($get !== []) {
                        /**
                         * Get all item fields type
                         */
                        $allItemFieldsType  = Item::getI()->getAllItemFieldsType();
                        $allItemFieldsClean = Item::getI()->getAllItemFieldsClean();
                        /**
                         * Check fields values from $_GET
                         */
                        foreach ($get as $key => $value) {

                            if (
                                isset($filtersList[$key])
                            ) {

                                if ($allItemFieldsType[$key] == 'fieldset_checkbox') {
                                    $getOk[$key][] = Clean::check($value, 'unsInt');
                                } else {
                                    $getOk[$key] = Clean::check($value, $allItemFieldsClean[$key]);
                                }

                                if ($getOk[$key] === false) {
                                    unset($getOk[$key]);
                                }
                            }
                        }
                        unset($key, $value);
                    }
                }
                /**
                 * Check filters note and $_GET
                 */
                if ($filtersNote != []) {

                    foreach ($filtersNote as $key => $value) {
                        if (isset($getOk[$key])) {
                            unset($filtersNote[$key]);
                        }
                    }
                    unset($key, $value);

                    $getFiltersValues = array_merge($filtersNote, $getOk);

                    $this->updateNote($getFiltersValues);
                    #
                } elseif ($getOk != []) {

                    $getFiltersValues = $getOk;

                    $this->saveNote($getFiltersValues);
                    #
                } else {

                    $getFiltersValues = [];
                    #
                }
                #
            }
            /**
             * If the global POST variable is NOT null
             */
            else {
                /**
                 * Checking the data received from the filter
                 */
                $getFiltersValues = (new \Core\Plugins\Check\FilterFields)->checkFilterFields(
                    require PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'fields.php'
                );
                /**
                 * If empty filters values
                 */
                if ($getFiltersValues == []) {

                    $getFiltersValues = null;
                    #
                }
                /**
                 * If NOT empty filters values
                 */
                else {
                    /**
                     * If empty filters note
                     */
                    if (FiltersNote::getI()->getFiltersNote() === false) {
                        /** 
                         * If the data is correct and there is no filter entry in the database
                         */
                        $this->saveNote($getFiltersValues);
                        #
                    }
                    /**
                     * If NOT empty filters note
                     */
                    else {
                        $this->updateNote($getFiltersValues);
                    }
                }
            }

            if (
                isset(Item::getI()->itemParams()['extra']) &&
                Item::getI()->itemParams()['extra'] != []
            ) {
                $getFiltersValues['extra'] =  Item::getI()->itemParams()['extra'];
            }

            $getFiltersValues = $getFiltersValues == null ? [] : $getFiltersValues;

            if (isset($getFiltersValues['order_by'])) {
                $this->orderBy = $getFiltersValues['order_by'];
                unset($getFiltersValues['order_by']);
            }

            $this->getFiltersValues = $getFiltersValues;
        }

        return $this->getFiltersValues;
    }
    /**
     * Save filters values to `control_post_note` table
     * @param array $getFiltersValues
     * @return integer
     */
    private function saveNote(array $getFiltersValues): int
    {
        return (int) DB::getI()->add(
            [
                'table_name' => 'control_post_note',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'token'        => Session::getToken(),
                        'controller_name' => Router::getRoute()['controller_name'],
                        'action_name'     => Router::getRoute()['action_name'],
                        'post_note'    => json_encode($getFiltersValues),
                        'enabled_to'   => time() + Config::getCfg('CFG_NOTE_ENABLED_TO'),
                    ]
                ),
                'array'      => $set,
            ]
        );
    }
    /**
     * Update filters value in `control_post_note` table
     * @param [type] $getFiltersValues
     * @return boolean
     */
    private function updateNote($getFiltersValues): bool
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
    /**
     * Delete not actual filters values
     * @return boolean
     */
    private function deleteOldNote(): bool
    {
        return DB::getI()->delete(
            [
                'table_name' => 'control_post_note',
                'where'      => '`enabled_to` < :enabled_to',
                'array'      => ['enabled_to' => time()],
            ]
        );
    }
    /**
     * Get filters html to page render
     * @return string
     */
    public function viewFiltersForm(): string
    {
        if ($this->getFiltersList() != []) {

            $values = [];

            if ($this->getFiltersValues() != []) {

                $filtersValues = $this->getFiltersValues();
                unset($filtersValues['extra']);

                if ($filtersValues != []) {

                    $allItemFieldsClean = Item::getI()->getAllItemFieldsClean();

                    foreach ($filtersValues as $key => $value) {

                        if ($allItemFieldsClean[$key] == 'time') {
                            $values[$key] = userDate(Config::getCfg('CFG_DATE_TIME_MYSQL_FORMAT'), $value);
                        } else {
                            $values[$key] = $value;
                        }
                    }
                    unset($key, $value, $filtersValues);
                }
            }

            if ($this->orderBy != 'null') {
                $values['order_by'] = $this->orderBy;
            }

            $actionUrl = Router::getRoute()['action_url'] == '' ? 'index' : Router::getRoute()['action_url'];

            $values['title']               = Item::getI()->itemParams()['title'];
            $values['filter_fields']       = PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'fields.php';
            $values['page_link']           = Router::getRoute()['controller_url'] . '/' . Router::getRoute()['action_url'] . '/';
            $values['filter_button_label'] = Trl::_('LABEL_SELECT');
            $values['filters_clear_link']  = Router::getRoute()['controller_url'] . '/' . $actionUrl . '-clear/';

            return Tpl::view(
                PATH_MODULES . 'Control' . DS . 'FiltersForm' . DS . 'filtersForm.php',
                $values
            );
            #
        } else {
            return '';
        }
    }
    /**
     * Return value search order
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
                    $this->orderBy = Item::getI()->itemParams()['order_by'];
                }
                #
            } elseif (isset($this->getFiltersValues()['order_by'])) {

                $orderBy = $this->getFiltersValues()['order_by'];

                if ($orderBy === 'ASC' || $orderBy === 'DESC') {
                    $this->orderBy = $orderBy;
                } else {
                    $this->orderBy = Item::getI()->itemParams()['order_by'];
                }
                #
            } else {
                $this->orderBy = Item::getI()->itemParams()['order_by'];
            }
        }

        return $this->orderBy;
    }
    /**
     * If isset filters file, return filters list or empty array
     * @return array // array or []
     */
    private function getFiltersList(): array
    {
        if ($this->getFiltersList == null) {

            if (
                is_readable(PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'fields.php')
            ) {
                $this->getFiltersList = require PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'fields.php';
            } else {
                $this->getFiltersList = [];
            }
        }

        return $this->getFiltersList;
    }

    private function __clone() {}
    public function __wakeup() {}
}
