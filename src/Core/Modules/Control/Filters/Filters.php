<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\Control\Filters;

defined('AIW_CMS') or die;

use Core\Config;
use Core\GV;
use Core\Modules\Control\Func;
use Core\Plugins\Dll\FiltersNote;
use Core\Plugins\View\Tpl;

class Filters extends Func
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Filters
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return correctly prepare sql
     * In key ['sql'] - sql string,
     * in key ['array'] - array to sql
     * @return array
     */
    public function filtersValuesToSql(): array
    {
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
                $filtersValuesToSql['sql']   = '`id` > 0';
                $filtersValuesToSql['array'] = [];
            } else {
                $filtersValuesToSql['sql']   = $sql;
                $filtersValuesToSql['array'] = $array;
            }
            #
        } else {

            if ($this->extra() != []) {
                $filtersValuesToSql['sql']   = substr($this->extra()['sql'], 0, -5);
                $filtersValuesToSql['array'] = $this->extra()['array'];
            } else {
                $filtersValuesToSql['sql']   = '`id` > 0';
                $filtersValuesToSql['array'] = [];
            }
        }

        return $filtersValuesToSql;
    }
    /**
     * Return correctly extra sql
     * In key ['sql'] - prepared SQL,
     * in key ['array'] - values to SQL
     * @return array
     */
    public function extra(): array
    {
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
            unset($key, $value, $key2, $value2);

            $extra['sql']   = $sql;
            $extra['array'] = $array;
            #
        }

        return $extra;
    }
    /**
     * Get values from filters
     * @return array|null
     */
    public function getFiltersValues(): array|null
    {
        /**
         * If the global $_POST variable is NULL,
         * i.e., data is not transmitted from the form
         */
        if (GV::post() === null) {
            /**
             * There is not a get from $_GET to $_POST
             */
            if (Func::getI()->fromGetToPost() === false) {

                if (FiltersNote::getI()->getFiltersNote() === false) {

                    $getFiltersValues = null;
                    #
                } else {

                    $getFiltersValues = json_decode(FiltersNote::getI()->getFiltersNote()['post_note'], true);

                    Func::getI()->updateNote($getFiltersValues);
                }
                #
            } else {

                if (FiltersNote::getI()->getFiltersNote() === false) {

                    $getFiltersValues = Func::getI()->fromGetToPost();

                    Func::getI()->saveNote($getFiltersValues);
                    #
                } else {

                    $getFiltersValues = json_decode(FiltersNote::getI()->getFiltersNote()['post_note'], true);

                    $fromGetToPost = Func::getI()->fromGetToPost();

                    foreach ($getFiltersValues as $key => $value) {

                        if (isset($fromGetToPost[$key])) {
                            $getFiltersValues[$key] = $fromGetToPost[$key];
                            unset($fromGetToPost[$key]);
                        }
                    }

                    $getFiltersValues = array_merge($getFiltersValues, $fromGetToPost);

                    Func::getI()->updateNote($getFiltersValues);
                }
            }
            #
        } else {
            /**
             * We check the data received from the filter
             */
            $getFiltersValues = (new \Core\Plugins\Check\FilterFields)->checkFilterFields(
                require Func::getI()->getParams()['filter_fields']
            );

            if ($getFiltersValues == []) {

                $getFiltersValues = null;
                #
            } else {

                if (FiltersNote::getI()->getFiltersNote() === false) {
                    /** 
                     * If the data is correct and there is no record of filters in the database
                     */
                    Func::getI()->saveNote($getFiltersValues);
                    #
                } else {
                    Func::getI()->updateNote($getFiltersValues);
                }
            }
        }

        return $getFiltersValues;
    }
    /**
     * Return in string HTML filters form
     * @return string
     */
    public function viewFiltersForm(): string
    {
        $path = PATH_MODULES . 'Control' . DS . 'Filters' . DS . 'filtersForm.php';

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
    private function __clone() {}
    public function __wakeup() {}
}
