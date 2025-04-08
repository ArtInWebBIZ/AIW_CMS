<?php

namespace Core\Plugins\Item\ControlToCont;

use Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

class Fields
{
    private static $prepareFields = null;
    private static $curDir       = null;
    /**
     * Return …
     * @return array
     */
    private static function prepareFields(): array
    {
        if (self::$prepareFields == null) {

            $addFields  = require PATH_APP . self::$curDir . DS . 'Add' . DS . 'inc' . DS . 'fields.php';
            $editFields = require PATH_APP . self::$curDir . DS . 'Edit' . DS . 'inc' . DS . 'fields.php';

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

    public static function checkFieldsType(array $filtersValues, string $controllerName)
    {
        $fieldsList = [];
        self::$curDir = $controllerName;

        $getAllItemFields = self::getAllItemFields();

        $defaultFields  = array_flip($getAllItemFields['default']);
        $langFields     = array_flip($getAllItemFields['lang']);
        $filtersFields  = array_flip($getAllItemFields['filters']);
        $fieldsetFields = array_flip($getAllItemFields['fieldset']);

        foreach ($filtersValues as $key => $value) {

            $keyOk = str_replace(['_from', '_to'], '', $key);

            if (isset($defaultFields[$keyOk])) {
                $fieldsList['itemFields'][$key] = $value;
            } elseif (isset($langFields[$keyOk])) {
                $fieldsList['langFields'][$key] = $value;
            } elseif (isset($filtersFields[$keyOk])) {
                $fieldsList['filtersFields'][$key] = $value;
            } elseif (isset($fieldsetFields[$keyOk])) {
                $fieldsList['fieldsetFields'][$key] = $value;
            } else {
                continue;
            }
        }
        unset($key, $value);

        return $fieldsList;
    }
    /**
     * Return all items fields list
     * @return array
     */
    public static function getAllItemFields(): array
    {
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

        $getAllItemFields = [
            'default'  => $defaultFields,
            'lang'     => $langFields,
            'filters'  => $filtersFields,
            'fieldset' => $fieldsetFields,
        ];

        return $getAllItemFields;
    }
}
