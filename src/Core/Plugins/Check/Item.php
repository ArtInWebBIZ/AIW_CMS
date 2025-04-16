<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item\{
    Author,
    AllItemFields,
    Alternate,
    Controller,
    CheckItem,
    ItemParams,
    ItemImg,
    ItemLang,
    Form,
    SaveItemEditLog,
    NotLangItemFields,
    PageMeta
};
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Session;

class Item
{
    private static $instance      = null;
    private $viewForm             = 'null';
    private $currControllerId     = 'null';
    private $getItemLang          = 'null';
    private $getNotLangItemFields = null;
    private $getAllItemsCurLang   = null;

    private function __construct() {}

    public static function getI(): Item
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * View items form
     * @return string
     */
    public function viewForm(array $values = []): string
    {
        if ($this->viewForm == 'null') {
            $this->viewForm = Form::viewForm($values);
        }

        return $this->viewForm;
    }
    /**
     * Return currently item id in table 'item_lang'
     * this website database
     * @return integer // item_lang id or 0
     */
    public function getItemCurLangId(): int
    {
        return (int) DB::getI()->getValue(
            [
                'table_name' => 'item_lang',
                'select'     => 'id',
                'where'      => ParamsToSql::getSql(
                    $where = [
                        'item_id'  => IntPageAlias::check(),
                        'cur_lang' => Session::getLang()
                    ]
                ),
                'array'      => $where,
            ]
        );
    }
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    public function checkForm(): array
    {
        return Form::checkForm();
    }
    /**
     * Return edited fields in array or empty array ([])
     * @return
     */
    public function checkEditedFields(): array
    {
        return Form::checkEditedFields();
    }
    /**
     * Return items array or false
     * @return array|bool // array or false
     */
    public function checkItem(): array|bool
    {
        return CheckItem::checkItem();
    }
    /**
     * Return item parameters
     * @return mixed // item params array or false
     */
    public function itemParams(): array|bool
    {
        return ItemParams::itemParams();
    }
    /**
     * Return controllers list or false
     * @return array // array or []
     */
    public function getControllerList(): array
    {
        return Controller::getList();
    }
    /**
     * Return current controllers ID or false
     * @return mixed // integer ID or false
     */
    public function currControllerId(): int|bool
    {
        if ($this->currControllerId == 'null') {
            $this->currControllerId = Controller::currControllerId();
        }

        return $this->currControllerId;
    }
    /**
     * Return current controllers name
     * @return string
     */
    public function currControllerName(): string
    {
        return Controller::currControllerName();
    }
    /**
     * Return full path (an image name) current items intro image
     * @return string
     */
    public function getImgPath(): string
    {
        return ItemImg::getImgPath();
    }
    /**
     * Return full path (an image name) for item intro image params
     * @return string
     */
    public function getItemImgPath(int $created, int $itemId, string $imageName): string
    {
        return ItemImg::getItemImgPath($created, $itemId, $imageName);
    }
    /**
     * Return needed languages item or false
     * @param array $params
     * @return mixed // array or false
     */
    public function getItemLang(): array|bool
    {
        if ($this->getItemLang == 'null') {
            $this->getItemLang = ItemLang::getItemLang();
        }

        return $this->getItemLang;
    }
    /**
     * Return in array items field list cur_lang
     * @return array // array or empty array []
     */
    public function getAllItemsCurLang(): array
    {
        if ($this->getAllItemsCurLang === null) {

            $this->getAllItemsCurLang = [];

            if (is_array($this->checkItem())) {

                $return = DB::getI()->getNeededItemField(
                    [
                        'table_name'          => 'item_lang',
                        'field_name'          => 'cur_lang', // example 'id' or 'id`,`edited_count`,`brand_status'
                        'where'               => ParamsToSql::getSql(
                            $where = ['item_id' => $this->checkItem()['id']]
                        ),
                        'array'               => $where
                    ]
                );

                $toReturn = [];

                if ($return != []) {

                    foreach ($return as $key => $value) {
                        $toReturn[] = $return[$key]['cur_lang'];
                    }
                    unset($key, $value, $return);
                    #
                }

                $this->getAllItemsCurLang = $toReturn;
            }
        }

        return $this->getAllItemsCurLang;
    }
    /**
     * Save items edit log
     * @param string $fieldName
     * @param string $value
     * @return boolean
     */
    public function saveItemEditLog(string $fieldName, string|array $value): bool
    {
        if (is_array($value)) {
            $newValue = trim(implode(",", $value), ",");
        } else {
            $newValue = $value;
        }

        return SaveItemEditLog::saveItemEditLog($fieldName, $newValue);
    }
    /**
     * Get in array all fields from table `item`
     * @return array
     */
    public function getItemFields(): array
    {
        return require PATH_INC . 'item' . DS . 'itemFields.php';
    }
    /**
     * Get in array all fields from table `item_lang`
     * @return array
     */
    public function getItemLangFields(): array
    {
        return require PATH_INC . 'item' . DS . 'langFields.php';
    }
    /**
     * Return all items fields list
     * @return array
     */
    public function getAllItemFields(): array
    {
        return AllItemFields::getAllItemFields();
    }
    /**
     * Return all items fields list
     * @return array
     */
    public function getAllItemFieldsList(): array
    {
        return AllItemFields::getAllItemFieldsList();
    }
    /**
     * Return all items fields list
     * @return array
     */
    public function getAllItemFieldsName(): array
    {
        return AllItemFields::getAllItemFieldsName();
    }
    /**
     * Return all items fields list
     * @return array
     */
    public function getAllItemFieldsType(): array
    {
        return AllItemFields::getAllItemFieldsType();
    }
    /**
     * Return all items fields list
     * @return array
     */
    public function getAllItemFieldsClean(): array
    {
        return AllItemFields::getAllItemFieldsClean();
    }
    /**
     * Return correct filter fields
     * @return array
     */
    public function getNotLangItemFields(): array
    {
        if ($this->getNotLangItemFields == null) {
            $this->getNotLangItemFields = NotLangItemFields::getNotLangItemFields();
        }

        return $this->getNotLangItemFields;
    }
    /**
     * Return item author full name
     * @return string
     */
    public function authorName(): string
    {
        return Author::authorName();
    }
    /**
     * Return corrects meta tags to item page
     * @return string
     */
    public function pageMeta(): string
    {
        return PageMeta::getMeta();
    }
    /**
     * Get correctly html alternate link
     * @return string
     */
    public function itemAlternate(): string
    {
        return Alternate::getItemAlternate();
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
