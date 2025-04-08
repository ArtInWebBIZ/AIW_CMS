<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item\Edit;

defined('AIW_CMS') or die;

use Core\{Config, Router};
use Core\Plugins\Check\Item;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

class Func
{
    private static $instance   = null;
    private $checkAccess = 'null';
    private $saveIntroImage    = null;
    private $checkItemLang     = 'null';
    private $checkEditedFields = null;
    private $newItemLang = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return users access to edit this item
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (
                is_array(Item::getI()->checkItem()) &&
                is_array(Item::getI()->itemParams()) &&
                Item::getI()->itemParams()['access'] === true
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * View items edit form
     * @return string
     */
    public function viewForm(): string
    {
        $fieldsList = $this->fieldsList();

        $v = [];

        foreach ($fieldsList as $key => $value) {
            $v[$key] = Item::getI()->checkItem()[$key];
        }

        return Item::getI()->viewForm($v);
    }
    /**
     * Get item edit fields list
     * @return array
     */
    private function fieldsList(): array
    {
        return require PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'fields.php';
    }
    /**
     * If success save new image,
     * return image name in key ['file_name'] and not isset key ['msg']
     * @param array $params
     * @return array
     */
    public function saveIntroImage(): array
    {
        if ($this->saveIntroImage == null) {

            $this->saveIntroImage = (new \Core\Plugins\Upload\OneImage)->uploadImage(
                [
                    'form_value'       => Item::getI()->checkForm(), // Get form values
                    'input_name'       => 'intro_img', // Get images files
                    'items_date'       => Item::getI()->checkItem()['created'],
                    'dir_name'         => Config::getCfg('CFG_INTRO_IMAGE_PATH'),
                    'items_id_or_code' => Item::getI()->checkItem()['id'],
                    'img_width'        => Config::getCfg('CFG_INTRO_IMAGE_WIDTH'),
                    'img_height'       => Config::getCfg('CFG_INTRO_IMAGE_HEIGHT'),
                ]
            );
        }

        return $this->saveIntroImage;
    }
    /**
     * Return edited fields in array or empty array ([])
     * @return array
     */
    private function checkEditedFields(): array
    {
        if ($this->checkEditedFields == null) {
            $this->checkEditedFields = Item::getI()->checkEditedFields();
        }

        return $this->checkEditedFields;
    }
    /**
     * Change 'intro_img' param to $this->checkEditedFields
     * @param string $value // 'save' or 'unset'
     * @return array
     */
    public function changeEditedFields(string $value = 'save')
    {
        if ($value === 'save') {
            $this->checkEditedFields['intro_img'] = $this->saveIntroImage()['file_name'];
        } else {
            unset($this->checkEditedFields['intro_img']);
        }

        return $this->checkEditedFields;
    }
    /**
     * Update changed items value in currently language in table `item_lang`
     * @return boolean
     */
    public function updItemLang(): bool
    {
        $editedFields = $this->checkEditedFields();

        $return = true;

        foreach ($editedFields as $key => $value) {
            if (in_array($key, Item::getI()->getAllItemFields()['lang'])) {
                $new[$key] = $value;
                unset($this->checkEditedFields[$key]);
            }
        }
        unset($key, $value);

        if (isset($new)) {

            $return = DB::getI()->update(
                [
                    'table_name' => 'item_lang',
                    'set'        => ParamsToSql::getSet($new),
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'item_id'  => Item::getI()->checkItem()['id'],
                            'cur_lang' => Item::getI()->checkItem()['cur_lang'],
                        ]
                    ),
                    'array'      => array_merge($new, $where),
                ]
            );
        }

        return $return;
    }
    /**
     * Return item from `item_lang` table
     * @return mixed // array or false
     */
    public function checkItemLang(): mixed
    {
        if ($this->checkItemLang == 'null') {

            $this->checkItemLang = DB::getI()->getRow(
                [
                    'table_name' => 'item_lang',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'item_id'  => Item::getI()->checkItem()['id'],
                            'cur_lang' => $this->checkEditedFields()['cur_lang'],
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkItemLang;
    }
    /**
     * Create new row to `item_lang` in currently language values
     * @return bool
     */
    public function newItemLang(): bool
    {
        if ($this->newItemLang === 'null') {

            $return = DB::getI()->add(
                [
                    'table_name' => 'item_lang',
                    'set'        => ParamsToSql::getSet(
                        $set = [
                            'item_id'     => Item::getI()->checkItem()['id'],
                            'cur_lang'    => $this->checkEditedFields()['cur_lang'],
                            'keywords'    => Item::getI()->checkForm()['keywords'],
                            'description' => Item::getI()->checkForm()['description'],
                            'heading'     => Item::getI()->checkForm()['heading'],
                            'intro_img'   => isset($this->checkEditedFields()['intro_img']) ?
                                $this->checkEditedFields()['intro_img'] :
                                Item::getI()->checkItem()['intro_img'],
                            'intro_text'  => Item::getI()->checkForm()['intro_text'],
                            'text'        => Item::getI()->checkForm()['text'],
                        ]
                    ),
                    'array'      => $set,
                ]
            );

            if ($return > 0) {
                /**
                 * Save to item edit log
                 */
                $editedFields = $this->checkEditedFields();

                foreach ($editedFields as $key => $value) {

                    if ($key == 'status') {

                        $return = $this->updateItemStatus($value);

                        if ($return === true) {
                            $return = Item::getI()->saveItemEditLog($key, $value);
                        }
                        #
                    } else {
                        $return = true;
                    }

                    if ($return === false) {
                        break;
                    }
                }

                $this->newItemLang = $return;
                #
            } else {
                $this->newItemLang = false;
            }
            #
        }

        return $this->newItemLang;
    }
    /**
     * Update items status
     * @param string $status
     * @return boolean
     */
    private function updateItemStatus(string $status): bool
    {
        return DB::getI()->update(
            [
                'table_name' => 'item',
                'set'        => ParamsToSql::getSet(
                    $set = ['status' => $status]
                ),
                'where'      => ParamsToSql::getSql(
                    $where = ['id' => Item::getI()->checkItem()['id'],]
                ),
                'array'      => array_merge($set, $where),
            ]
        );
    }
    /**
     * Update edited fields in table `item`
     * @return boolean
     */
    public function checkEditedItemsFields(): bool
    {
        $result = true;

        $editedFields = $this->checkEditedFields();

        foreach ($editedFields as $key => $value) {
            if (in_array($key, Item::getI()->getAllItemFields()['default'])) {
                $new[$key] = $value;
                unset($this->checkEditedFields[$key]);
            }
        }
        unset($key, $value);

        if (isset($new)) {

            $result = DB::getI()->update(
                [
                    'table_name' => 'item',
                    'set'        => ParamsToSql::getSet($new),
                    'where'      => ParamsToSql::getSql(
                        $where = ['id' => Item::getI()->checkItem()['id']]
                    ),
                    'array'      => array_merge($new, $where),
                ]
            );
        }

        return $result;
    }
    /**
     * Update edited fields for fieldset fields type
     * @return boolean
     */
    public function checkEditedFieldsetFields(): bool
    {
        $editedFields = $this->checkEditedFields();

        $result = true;

        foreach ($editedFields as $key => $value) {

            if (in_array($key, Item::getI()->getAllItemFields()['fieldset'])) {

                $oldFieldsetValues = Item::getI()->checkItem()[$key];

                $old = array_diff($oldFieldsetValues, $this->checkEditedFields()[$key]);

                if ($old != []) {

                    $in = ParamsToSql::getInSql($old);
                    $result = DB::getI()->delete(
                        [
                            'table_name' => 'item_' . $key,
                            'where'      => '`item_id` = :item_id AND `' . $key . '` ' . $in['in'],
                            'array'      => array_merge(['item_id' => Item::getI()->checkItem()['id']], $in['array']),
                        ]
                    );
                }

                $new = array_diff($this->checkEditedFields()[$key], $oldFieldsetValues);

                if ($new != []) {

                    $result = DB::getI()->fieldset(
                        [
                            'table_name'  => 'item_' . $key,
                            'item_id'     => Item::getI()->checkItem()['id'],
                            'field_value' => $new,
                        ]
                    );
                }
                unset($this->checkEditedFields[$key]);
            }
        }
        unset($key, $value);

        return $result;
    }
    /**
     * Update filters fields changed values
     * @return boolean
     */
    public function checkEditedFiltersFields(): bool
    {
        $result = true;

        $editedFields = $this->checkEditedFields();

        foreach ($editedFields as $key => $value) {
            if (in_array($key, Item::getI()->getAllItemFields()['filters'])) {
                $new[$key] = $value;
                unset($this->checkEditedFields[$key]);
            }
        }
        unset($key, $value);

        if (isset($new)) {

            $result = DB::getI()->update(
                [
                    'table_name' => 'item_' . Item::getI()->currControllerName(),
                    'set'        => ParamsToSql::getSet($new),
                    'where'      => ParamsToSql::getSql(
                        $where = ['item_id' => Item::getI()->checkItem()['id']]
                    ),
                    'array'      => array_merge($new, $where),
                ]
            );
        }

        return $result;
    }
    /**
     * Save edited values to `item_edit_log` table
     * @return boolean
     */
    public function saveToEditLog(): bool
    {
        $editedFields = $this->checkEditedFields();

        foreach ($editedFields as $key => $value) {
            if (Item::getI()->saveItemEditLog($key, $value) === false) {
                die("Incorrect save to log key – $key");
            }
        }
        unset($key, $value);

        return true;
    }
    /**
     * Change item edited date
     * @return boolean
     */
    public function changeItemEditedDate(): bool
    {
        return DB::getI()->update(
            [
                'table_name' => 'item',
                'set'        => ParamsToSql::getSet(
                    $set = ['edited' => time()]
                ),
                'where'      => ParamsToSql::getSql(
                    $where = ['id' => Item::getI()->checkItem()['id']]
                ),
                'array'      => array_merge($set, $where),
            ]
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
