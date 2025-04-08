<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item\Add;

defined('AIW_CMS') or die;

use Core\{Auth, Config, Languages, Router};
use Core\Modules\Randomizer;
use Core\Plugins\Check\Item;
use Core\Plugins\Model\DB;
use Core\Plugins\{Msg, ParamsToSql};

class Func
{
    private static $instance = null;
    private $checkForm = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';
    /**
     * Return user access value
     * @return bool
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (isset($this->itemParams()['access'])) {
                $this->checkAccess = $this->itemParams()['access'];
            }
        }

        return $this->checkAccess;
    }
    /**
     * Return item parameters
     * @return mixed // item params array or false
     */
    public function itemParams(): mixed
    {
        return Item::getI()->itemParams();
    }
    /**
     * View add items form
     * @return string
     */
    public function viewForm(): string
    {
        return Item::getI()->viewForm();
    }
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    public function checkForm(): array
    {
        if ($this->checkForm == null) {
            $this->checkForm = Item::getI()->checkForm();
        }

        return $this->checkForm;
    }
    #
    private $otherFields = null;
    /**
     * Return other content fields, from not form values
     * @return array
     */
    private function otherFields(): array
    {
        if ($this->otherFields == null) {

            /**
             * Get other items fields
             */
            if (
                isset(Item::getI()->itemParams()['other_fields']) &&
                Item::getI()->itemParams()['other_fields'] != []
            ) {
                $this->otherFields = Item::getI()->itemParams()['other_fields'];
            } else {
                $this->otherFields = [];
            }
        }

        return $this->otherFields;
    }
    #
    private $saveItem = 'null';
    /**
     * Return …
     * @return mixed // item ID or error message in array key ['msg']
     */
    public function saveItem(): mixed
    {
        if ($this->saveItem == 'null') {
            /**
             * Check controllers id
             */
            if (Item::getI()->currControllerId() !== false) {
                /**
                 * Save new item to `item` table
                 */
                if ($this->saveNewItem() > 0) {
                    /**
                     * Save intro image to server
                     */
                    if (!isset($this->saveIntroImage()['msg'])) {
                        /**
                         * Save items value
                         */
                        if ($this->saveItemLang() > 0) {
                            /**
                             * Save fieldset item values
                             */
                            if ($this->saveToFieldset()) {
                                /**
                                 * Save to filters table
                                 */
                                if ($this->saveToFiltersTable()) {
                                    /**
                                     * Return item ID
                                     */
                                    $this->saveItem = $this->saveNewItem();
                                    #
                                } else {
                                    $this->saveItem['msg'] = Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR');
                                }
                                #
                            } else {
                                $this->saveItem['msg'] = Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR');
                            }
                            #
                        } else {
                            $this->saveItem['msg'] = Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR');
                        }
                        #
                    } else {
                        $this->saveItem['msg'] = $this->saveIntroImage()['msg'];
                    }
                    #
                } else {
                    $this->saveItem['msg'] = Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR');
                }
                #
            } else {
                /**
                 * View error message
                 */
                $this->saveItem['msg'] = Msg::getMsg_('warning', 'MSG_ERROR_CONTROLLER_URL');
            }
        }

        return $this->saveItem;
    }
    #
    private $saveNewItem = 'null';
    /**
     * Save new item
     * Return new items ID or 0
     * @return integer
     */
    public function saveNewItem(): int
    {
        if ($this->saveNewItem == 'null') {

            $set = [
                'item_controller_id' => Item::getI()->currControllerId(),
                'author_id'          => Auth::getUserId(),
                'promo_code'         => $this->promoCode(),
                'def_lang'           => $this->lang(),
                'created'            => $this->newPostTime(),
                'edited'             => $this->newPostTime(),
                'self_order'         => isset($this->checkForm()['self_order']) && $this->checkForm()['self_order'] != '' ? (int) $this->checkForm()['self_order'] : 5000,
            ];

            if (isset($this->otherFields()['default'])) {

                $default = $this->otherFields()['default'];

                foreach ($default as $key => $value) {
                    if (isset($set[$key])) {
                        $set[$key] = $value;
                        unset($default[$key]);
                    }
                }
                unset($key, $value);

                if ($default != []) {
                    $set = array_merge($set, $default);
                }
                #
            }

            $this->saveNewItem = (int) DB::getI()->add(
                [
                    'table_name' => 'item',
                    'set'        => ParamsToSql::getSet($set),
                    'array'      => $set,
                ]
            );
        }

        return $this->saveNewItem;
    }
    #
    private $promoCode = 'null';
    /**
     * Return items promo code
     * @return string
     */
    public function promoCode(): string
    {
        if ($this->promoCode == 'null') {

            $this->promoCode = Randomizer::getRandomStr(
                Config::getCfg('CFG_MIN_REF_CODE_LEN'),
                Config::getCfg('CFG_MAX_REF_CODE_LEN')
            );
            #
        }

        return $this->promoCode;
    }
    #
    private $newPostTime = 'null';
    /**
     * Get new post time
     * @return integer
     */
    public function newPostTime(): int
    {
        if ($this->newPostTime == 'null') {
            $this->newPostTime = time();
        }

        return $this->newPostTime;
    }
    #
    private $lang = 'null';
    /**
     * Get correct default items language
     * @return string
     */
    private function lang(): string
    {
        if ($this->lang == 'null') {

            $this->lang = count(Languages::langList()) > 1 ? $this->checkForm()['cur_lang'] : Languages::langList()[0][0];

            if (isset($this->checkForm()['cur_lang'])) {
                unset($this->checkForm['cur_lang']);
            }
        }

        return $this->lang;
    }
    #
    private $saveIntroImage = null;
    /**
     * Save to server intro image
     * Return if success empty key ['msg']
     * Return if error empty key ['file_name']
     * @return array
     */
    public function saveIntroImage(): array
    {
        if ($this->saveIntroImage == null) {

            $this->saveIntroImage = (new \Core\Plugins\Upload\OneImage)->uploadImage(
                [
                    'form_value'        => $this->checkForm(), // Get form values
                    'input_name'        => 'intro_img', // Get images files
                    'items_date'        => $this->newPostTime(), // 
                    'dir_name'          => Config::getCfg('CFG_INTRO_IMAGE_PATH'), // 
                    'items_id_or_code'  => $this->saveNewItem(), // 
                    'img_width'         => Config::getCfg('CFG_INTRO_IMAGE_WIDTH'), // 
                    'img_height'        => Config::getCfg('CFG_INTRO_IMAGE_HEIGHT'), // 
                ]
            );
        }

        return $this->saveIntroImage;
    }
    #
    private $saveItemLang = 'null';
    /**
     * Undocumented function
     * @return integer // ID or 0
     */
    public function saveItemLang()
    {
        if ($this->saveItemLang == 'null') {

            $set = [
                'item_id'     => $this->saveNewItem(),
                'cur_lang'    => $this->lang(),
                'keywords'    => $this->checkForm()['keywords'],
                'description' => $this->checkForm()['description'],
                'heading'     => $this->checkForm()['heading'],
                'intro_img'   => $this->saveIntroImage()['file_name'],
                'intro_text'  => $this->checkForm()['intro_text'],
                'text'        => $this->checkForm()['text'],
            ];

            if (isset($this->otherFields()['lang'])) {

                $lang = $this->otherFields()['lang'];

                foreach ($lang as $key => $value) {
                    if (isset($set[$key])) {
                        $set[$key] = $value;
                        unset($lang[$key]);
                    }
                }
                unset($key, $value);

                if ($lang != []) {
                    $set = array_merge($set, $lang);
                }
                #
            }

            $this->saveItemLang = (int) DB::getI()->add(
                [
                    'table_name' => 'item_lang',
                    'set'        => ParamsToSql::getSet($set),
                    'array'      => $set,
                ]
            );
        }

        return $this->saveItemLang;
    }
    #
    private $saveToFieldset = 'null';
    /**
     * Return …
     * @return bool
     */
    public function saveToFieldset(): bool
    {
        if ($this->saveToFieldset == 'null') {

            $this->saveToFieldset = true;
            /**
             * Check in fields list fieldset fields
             */
            if (
                isset(Item::getI()->getAllItemFields()['fieldset']) &&
                Item::getI()->getAllItemFields()['fieldset'] != []
            ) {

                $fieldsetFields = Item::getI()->getAllItemFields()['fieldset'];

                foreach ($fieldsetFields as $key => $value) {
                    if (
                        isset($this->checkForm()[$value]) &&
                        $this->checkForm()[$value] != []
                    ) {
                        $this->saveToFieldset = (bool) DB::getI()->fieldset(
                            [
                                'table_name'  => 'item_' . $value,
                                'item_id'     => $this->saveNewItem(),
                                'field_value' => $this->checkForm()[$value],
                            ]
                        );
                    }
                }
                unset($key, $value);
            }
        }

        return $this->saveToFieldset;
    }
    #
    private $saveToFiltersTable = 'null';
    /**
     * Return results save values to item filters table
     * @return bool
     */
    private function saveToFiltersTable(): bool
    {
        if ($this->saveToFiltersTable == 'null') {

            $this->saveToFiltersTable == true;

            $filtersFields = array_flip(Item::getI()->getAllItemFields()['filters']);

            $filtersValue = [];

            foreach ($filtersFields as $key => $value) {

                if (isset($this->checkForm()[$key])) {
                    $filtersValue[$key] = $this->checkForm()[$key];
                }
                #
            }
            unset($key, $value, $filtersFields);

            if (isset($this->otherFields()['filters'])) {

                $filtersOther = $this->otherFields()['filters'];

                foreach ($filtersValue as $key => $value) {
                    if (isset($filtersOther[$key])) {
                        $filtersValue[$key] = $filtersOther[$key];
                        unset($filtersOther[$key]);
                    }
                }
                unset($key, $value);

                if ($filtersOther != []) {
                    $filtersValue = array_merge($filtersValue, $filtersOther);
                    foreach ($filtersValue as $key => $value) {
                        if ($value === '') {
                            unset($filtersValue[$key]);
                        }
                    }
                    unset($key, $value);
                }
                #
            }

            if (
                $filtersValue != [] &&
                isset(Item::getI()->getControllerList()[Item::getI()->currControllerName()])
            ) {

                $return = DB::getI()->add(
                    [
                        'table_name' => 'item_' . Item::getI()->currControllerName(),
                        'set'        => ParamsToSql::getSet(
                            $set = array_merge(['item_id' => $this->saveNewItem()], $filtersValue)
                        ),
                        'array'      => $set,
                    ]
                );

                if ($return > 0) {
                    $this->saveToFiltersTable = true;
                } else {
                    $this->saveToFiltersTable = false;
                }
            }
        }

        return $this->saveToFiltersTable;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
