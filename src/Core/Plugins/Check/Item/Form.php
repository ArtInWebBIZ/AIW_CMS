<?php

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Router;
use Core\Plugins\View\Tpl;
use Core\Plugins\Dll\OrganiseArray;

class Form
{
    private static $checkEditedFields = null;
    private static $checkForm  = null;

    /**
     * View items form
     * @return string
     */
    public static function viewForm(array $values): string
    {
        if (file_exists(PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'itemFormParams.php')) {

            if ($values != []) {
                $v = $values;
            }

            return Tpl::view(
                PATH_TPL . 'view' . DS . 'formView.php',
                require PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'itemFormParams.php'
            );
            #
        } else {
            return 'Incorrect file exist itemFormParams';
        }
    }
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    public static function checkForm(): array
    {
        if (self::$checkForm === null) {

            self::$checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require PATH_APP . Router::getRoute()['controller_name'] . DS . Router::getRoute()['action_name'] . DS . 'inc' . DS . 'fields.php'
            );
        }

        return self::$checkForm;
    }
    /**
     * Return edited fields in array or empty array ([])
     * @return
     */
    public static function checkEditedFields(): array
    {
        if (self::$checkEditedFields == null) {
            /**
             * Get all items field possible to edit
             */
            $fieldsArr = require PATH_APP . Router::getRoute()['controller_name'] . DS . 'Edit' . DS . 'inc' . DS . 'fields.php';

            $activeFields = [];

            foreach ($fieldsArr as $key => $value) {
                if ($fieldsArr[$key] !== null) {
                    $activeFields[$key] = '';
                }
            }
            unset($key, $value);

            $fields = array_keys($activeFields);
            unset($activeFields);

            $checkEditedFields = [];

            foreach ($fields as $key => $value) {

                if (
                    $fieldsArr[$value]['required'] === false &&
                    !isset(Item::getI()->checkForm()[$value])
                ) {
                    continue;
                    #
                } else {

                    if (is_array(Item::getI()->checkForm()[$value])) {
                        $formValue = OrganiseArray::organise(Item::getI()->checkForm()[$value]);
                    } else {
                        $formValue = Item::getI()->checkForm()[$value];
                        if (
                            ( #
                                $fieldsArr[$value]['clean'] == 'int' ||
                                $fieldsArr[$value]['clean'] == 'unsInt' ||
                                $fieldsArr[$value]['clean'] == 'time'
                            ) &&
                            isset(Item::getI()->checkForm()[$value]) &&
                            $formValue == ''
                        ) {
                            $formValue = 0;
                        }
                    }
                }

                $itemValue = Item::getI()->checkItem()[$value];
                $itemValue = is_array($itemValue) ? OrganiseArray::organise($itemValue) : $itemValue;

                if (
                    isset(Item::getI()->checkForm()[$value]) &&
                    $formValue != $itemValue
                ) {
                    $checkEditedFields[$value] = $formValue;
                }
            }
            unset($key, $value);

            self::$checkEditedFields = $checkEditedFields;
            #
        }

        return self::$checkEditedFields;
    }
}
