<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ItemController\Edit\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Router};
use Core\Plugins\Check\{CheckForm, CheckToken, GroupAccess, IntPageAlias};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\{Style, Tpl};

class Func
{
    private static $instance   = null;
    private $checkAccess       = 'null';
    private $viewForm          = 'null';
    private $checkForm         = [];
    private $saveToDb          = 'null';
    private $checkEditedFields = null;
    private $checkItem         = null;
    private $saveToEditLog     = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check user`s access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                is_array($this->checkItem()) &&
                GroupAccess::check([5])
            ) {
                $this->checkAccess = true;
            }
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

            /**
             * Get old values for insert to edit form
             */
            $v = [];

            foreach ($this->checkItem() as $key => $value) {
                $v[$key] = $value;
            }
            unset($key, $value);

            $this->viewForm = Tpl::view(
                PATH_TPL . 'view' . DS . 'formView.php',
                [
                    'enctype'             => false, // false or true
                    'section_css'         => Style::form()['section_css'], // sessions style
                    'container_css'       => Style::form()['container_css'], // container style
                    'overflow_css'        => Style::form()['overflow_css'], // overflow style
                    'button_div_css'      => Style::form()['button_div_css'], // buttons div style
                    'h_margin'            => Style::form()['h_margin'], // title style
                    'submit_button_style' => '', // submit button style
                    'button_id'           => '',
                    'h'                   => 'h1', // title weight
                    'title'               => 'TITLE_CONSTANT', // or null
                    'url'                 => Router::getRoute()['controller_url'] . '/edit/' . IntPageAlias::check() . '.html',
                    'cancel_url'          => Router::getRoute()['controller_url'] . '/',
                    'v_image'             => null, // or image path
                    'fields'              => require ForAll::contIncPath() . 'fields.php',
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
            $this->checkForm = CheckForm::check(ForAll::contIncPath() . 'fields.php');
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
            $this->checkEditedFields = CheckForm::checkEditedFields(
                $this->checkForm(),
                $this->checkItem()
            );
        }

        return $this->checkEditedFields;
    }
    /**
     * Return all items data
     * @return mixed // array or false
     */
    private function checkItem(): mixed
    {
        if ($this->checkItem === null) {

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

            if ($this->checkEditedFields() != []) {

                $insertToLog = [];

                foreach ($this->checkEditedFields() as $key => $value) {
                    $insertToLog[] = [
                        'edited_id'    => $this->checkItem()['id'],
                        'editor_id'    => Auth::getUserId(),
                        'edited_field' => $key,
                        'old_value'    => $this->checkItem()[$key],
                        'new_value'    => $value,
                        'edited'       => time(),
                    ];
                }
                unset($key, $value);

                $this->saveToEditLog = DB::getI()->insertInto(
                    str_replace('-', '_', Router::getRoute()['controller_url']) . '_edit_log',
                    $insertToLog
                );
            }
        }

        return $this->saveToEditLog;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
