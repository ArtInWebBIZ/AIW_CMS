<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Router;
use Core\Trl;

class AllItemFields
{
    private static $getAllItemFields     = null;
    private static $getAllItemFieldsName = null;
    private static $getAllItemFieldsType = null;
    private static $getAllItemFieldsClean = null;
    private static $getAllItemFieldsList = null;
    private static $prepareFields        = null;
    /**
     * Delete doubles items add and edit fields
     * @return array
     */
    private static function prepareFields(): array
    {
        if (self::$prepareFields == null) {

            $addFields  = require PATH_APP . Router::getRoute()['controller_name'] . DS . 'Add' . DS . 'inc' . DS . 'fields.php';
            $editFields = require PATH_APP . Router::getRoute()['controller_name'] . DS . 'Edit' . DS . 'inc' . DS . 'fields.php';

            $allFormFields = [];

            foreach ($addFields as $key => $value) {
                $allFormFields[$key] = $addFields[$key];
                if (isset($editFields[$key])) {
                    unset($editFields[$key]);
                }
            }
            unset($key, $value);

            if ($editFields != []) {
                $allFormFields = array_merge($allFormFields, $editFields);
            }

            self::$prepareFields = $allFormFields;
        }

        return self::$prepareFields;
    }
    #
    /**
     * Return all items fields list
     * @return array
     */
    public static function getAllItemFields(): array
    {
        if (self::$getAllItemFields == null) {

            $defaultFields  = Item::getI()->getItemFields();
            $langFields     = Item::getI()->getItemLangFields();

            $allFormFields = self::prepareFields();

            $fieldsetFields = [];
            $filtersFields  = [];

            $standardFields = array_merge($defaultFields, $langFields);

            foreach ($allFormFields as $key => $value) {

                if (in_array($key, $standardFields)) {
                    continue;
                } else {
                    if ($allFormFields[$key]['type'] == 'fieldset_checkbox') {
                        $fieldsetFields[] = $key;
                    } else {
                        $filtersFields[] = $key;
                    }
                }
            }

            self::$getAllItemFields = [
                'default'  => $defaultFields,
                'lang'     => $langFields,
                'filters'  => $filtersFields,
                'fieldset' => $fieldsetFields,
            ];

            return self::$getAllItemFields;
        }

        return self::$getAllItemFields;
    }
    /**
     * Return all items fields list
     * @return array
     */
    public static function getAllItemFieldsList(): array
    {
        if (self::$getAllItemFieldsList == null) {

            $getAllItemFields = self::getAllItemFields();
            $list = [];

            if (isset($getAllItemFields['default'])) {
                $list = array_merge($list, ['status']);
            }

            if (isset($getAllItemFields['lang'])) {
                $list = array_merge($list, $getAllItemFields['lang']);
            }

            if (isset($getAllItemFields['filters'])) {
                $list = array_merge($list, $getAllItemFields['filters']);
            }

            if (isset($getAllItemFields['fieldset'])) {
                $list = array_merge($list, $getAllItemFields['fieldset']);
            }

            self::$getAllItemFieldsList = array_flip($list);
            #
        }

        return self::$getAllItemFieldsList;
    }
    /**
     * Return all items fields names list
     * @return array
     */
    public static function getAllItemFieldsName(): array
    {
        if (self::$getAllItemFieldsName == null) {

            $allFormFields = self::prepareFields();

            $fieldName = [];

            foreach ($allFormFields as $key => $value) {
                $fieldName[$key] = $value['label'];
            }

            self::$getAllItemFieldsName = $fieldName;
        }

        return self::$getAllItemFieldsName;
    }
    /**
     * Return all items fields type
     * @return array
     */
    public static function getAllItemFieldsType(): array
    {
        if (self::$getAllItemFieldsType === null) {

            $allFormFields = self::prepareFields();

            $fieldType = [];

            foreach ($allFormFields as $key => $value) {
                $fieldType[$key] = $value['type'];
            }

            self::$getAllItemFieldsType = $fieldType;
            #
        }

        return self::$getAllItemFieldsType;
    }
    /**
     * Return all items fields type
     * @return array
     */
    public static function getAllItemFieldsClean(): array
    {
        if (self::$getAllItemFieldsClean === null) {

            $allFormFields = self::prepareFields();

            $fieldType = [];

            foreach ($allFormFields as $key => $value) {
                if (isset($value['clean'])) {
                    $fieldType[$key] = $value['clean'];
                } else {
                    $fieldType[$key] = 'unsInt';
                }
            }

            self::$getAllItemFieldsClean = $fieldType;
            #
        }

        return self::$getAllItemFieldsClean;
    }
    /**
     * Return currently fields name in currently language
     * @return string
     */
    public static function getValueName(string $fieldName, string|int $value, string $path = null): string
    {
        $tmp = $value;

        $path = $path === null ? Router::getRoute()['controller_url'] : $path;

        if (
            file_exists(PATH_INC . $path . DS . $fieldName . '.php')
        ) {

            $return = array_flip(require PATH_INC . $path . DS . $fieldName . '.php');

            if (isset($return[$value])) {
                $tmp = Trl::_($return[$value]);
            } else {

                $variable = explode(",", $value);

                $array = [];

                foreach ($variable as $key => $fieldsName) {
                    if (isset($return[$fieldsName])) {
                        $array[] = Trl::_($return[$fieldsName]);
                    }
                }

                $tmp = trim(implode(", ", $array), ", ");
            }
        }

        return $tmp;
    }
    #
}
