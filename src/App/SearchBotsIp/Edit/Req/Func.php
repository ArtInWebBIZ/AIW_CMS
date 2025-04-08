<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\SearchBotsIp\Edit\Req;

defined('AIW_CMS') or die;

use Core\Plugins\Check\IntPageAlias;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Tpl;
use Core\Router;

class Func
{
    private static $instance   = null;
    private $checkAccess       = 'null';
    private $viewForm          = 'null';
    private $checkEditedFields = null;
    private $saveToEditLog     = 'null';
    private $checkItem         = 'null';
    private $saveToDb          = 'null';
    private $checkForm         = [];

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function checkAccess()
    {
        if ($this->checkAccess == 'null') {
            $this->checkAccess = false;
        }

        return $this->checkAccess;
    }
    /**
     * Return view edit form
     * @return string
     */
    public function viewForm(): string
    {
        if ($this->viewForm == 'null') {

            $this->viewForm = Tpl::view(
                PATH_TPL . 'view' . DS . 'formView.php',
                [
                    'enctype'             => false, // false or true
                    'section_css'         => 'content-section uk-padding-small', // sessions style
                    'container_css'       => '', // container style
                    'overflow_css'        => '', // overflow style
                    'button_div_css'      => 'uk-margin-medium-top', // buttons div style
                    'submit_button_style' => '', // submit button style
                    'button_id'           => '',
                    'h'                   => 'h1', // title weight
                    'h_margin'            => 'uk-margin-large-bottom', // title style
                    'title'               => 'TITLE_CONSTANT', // or null
                    'url'                 => '/' . Router::getRoute()['controller_url'] . '/edit/',
                    'cancel_url'          => null, // or '/controller/action/' or 'hidden'
                    'v_image'             => null, // or image path
                    'fields'              => require PATH_APP . Router::getRoute()['controller_name'] . DS . 'Edit' . DS . 'inc' . DS . 'fields.php',
                    'button_label'        => 'CONSTANT_BUTTON_LABEL',
                    'include_after_form'  => '', // include after form
                ]
            );
        }

        return $this->viewForm;
    }
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    public function checkForm(): array
    {
        if ($this->checkForm == []) {

            $this->checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require PATH_APP . 'SearchBotsIp' . DS . 'Edit' . DS . 'inc' . DS . 'fields.php'
            );
        }

        return $this->checkForm;
    }
    /**
     * Return new content type ID in data base
     * @return bool
     */
    public function saveToDb(): bool
    {
        if ($this->saveToDb == 'null') {

            $set = [];

            foreach ($this->checkEditedFields() as $key => $value) {
                $set[$key] = $value;
            }
            unset($key, $value);

            $set['edited'] = time();

            $this->saveToDb = (bool) DB::getI()->update(
                [
                    'table_name' => str_replace("-", "_", Router::getRoute()['controller_url']),
                    'set'        => ParamsToSql::getSet($set),
                    'where'      => ParamsToSql::getSql(
                        $where = ['id' => IntPageAlias::check()]
                    ),
                    'array'      => array_merge($set, $where),
                ]
            );
        }

        return $this->saveToDb;
    }
    /**
     * Return array or empty array
     * @return array // array or []
     */
    public function checkEditedFields(): array
    {
        if ($this->checkEditedFields === null) {

            if (is_array($this->checkItem())) {

                $fieldsArr = require PATH_APP . Router::getRoute()['controller_name'] . DS . 'Edit' . DS . 'inc' . DS . 'fields.php';

                foreach ($fieldsArr as $key1 => $value1) {
                    if ($fieldsArr[$key1] !== null) {
                        $activeFields[$key1] = '';
                    }
                }
                unset($key1, $value1);

                $fieldsArr = array_keys($activeFields);

                $this->checkEditedFields = [];

                foreach ($fieldsArr as $key => $value) {

                    if (
                        isset($this->checkForm()[$value]) &&
                        $this->checkForm()[$value] != $this->checkItem()[$value]
                    ) {
                        $this->checkEditedFields[$value] = $this->checkForm()[$value];
                    }
                }
                unset($key, $value);
                #
            } else {
                $this->checkEditedFields = [];
            }
        }

        return $this->checkEditedFields;
    }
    /**
     * Return all items data
     * @return mixed // array or false
     */
    private function checkItem(): mixed
    {
        if ($this->checkItem == 'null') {

            $this->checkItem = DB::getI()->getRow(
                [
                    'table_name' => str_replace('-', '_', Router::getRoute()['controller_url']),
                    'where'      => ParamsToSql::getSql(
                        $where = ['id' => (int) IntPageAlias::check()]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkItem;
    }
    /**
     * Save new values to log
     * @return bool
     */
    public function saveToEditLog(): bool
    {
        if ($this->saveToEditLog == 'null') {

            $this->saveToEditLog = DB::getI()->insertInto(
                [
                    'table_name'   => str_replace('-', '_', Router::getRoute()['controller_url']) . '_edit_log',
                    'fields_list'  => ['field_1', 'field_2', 'field_3'], #:TODO
                    'fields_value' => [ #:TODO
                        ['field_1_value_1', 'field_2_value_1', 'field_3_value_1'],
                        ['field_1_value_2', 'field_2_value_2', 'field_3_value_2'],
                        ['field_1_value_3', 'field_2_value_3', 'field_3_value_3'],
                        ['field_1_value_4', 'field_2_value_4', 'field_3_value_4'],
                    ],
                ]
            );
        }

        return $this->saveToEditLog;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
