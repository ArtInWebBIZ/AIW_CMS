<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Modules\View;

use Core\Plugins\Check\Item;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Trl;

defined('AIW_CMS') or die;

class FiltersConstruct
{
    public function getFormConstruct(array $fields): string
    {
        $formConstruct = '';

        foreach ($fields as $key => $value) {

            if ($fields[$key] === null) {
                continue;
            }

            $disabled    = $fields[$key]['disabled'] ? ' disabled' : '';
            $required    = $fields[$key]['required'] ? ' required' : '';
            $minlength   = !isset($fields[$key]['minlength']) || $fields[$key]['minlength'] == '' ? '' : ' minlength="' . $fields[$key]['minlength'] . '"';
            $maxlength   = !isset($fields[$key]['maxlength']) || $fields[$key]['maxlength'] == '' ? '' : ' maxlength="' . $fields[$key]['maxlength'] . '"';
            $placeholder = isset($fields[$key]['placeholder']) && $fields[$key]['placeholder'] != '' ? ' placeholder="' . $fields[$key]['placeholder'] . '"' : '';
            $class = !isset($fields[$key]['class']) || $fields[$key]['class'] == '' ? '' : ' class="' . $fields[$key]['class'] . ' input-shadow"';

            if (
                $fields[$key]['type'] == 'text' ||
                $fields[$key]['type'] == 'date' ||
                $fields[$key]['type'] == 'email' ||
                $fields[$key]['type'] == 'hidden' ||
                $fields[$key]['type'] == 'password'
            ) {

                $value = $fields[$key]['value'] == '' ? '' : ' value="' . $fields[$key]['value'] . '"';

                if (
                    strpos($fields[$key]['name'], '_to') !== false ||
                    strpos($fields[$key]['name'], '_from') !== false
                ) {
                    $onFocus = '';
                } else {
                    $onFocus = ' onfocus="this.value=\'\'"';
                }

                $input = '
                    <input type="' . $fields[$key]['type'] . '" name="' . $fields[$key]['name'] . '" ' . $required . ' id="' . $fields[$key]['name'] . '" ' . $minlength . $maxlength . $class . $disabled . $placeholder . $value . $onFocus . '>';
                #
            } elseif (
                $fields[$key]['type'] == 'select'
            ) {
                $input = '
                    <select name="' . $fields[$key]['name'] . '" ' . $required . ' id="' . $fields[$key]['name'] . '" ' . $class . '>
                        ' . $fields[$key]['value'] . $disabled . '
                    </select>';
                #
            } elseif (
                $fields[$key]['type'] == 'checkbox'
            ) {

                $input = '
                    <input type="' . $fields[$key]['type'] . '" name="' . $fields[$key]['name'] . '" id="' . $fields[$key]['name'] . '" ' . $class . ' value="' . $fields[$key]['value'] . '">';
                #
            }

            $requiredStar = ($fields[$key]['required']) ? '&nbsp;*' : '';

            $hidden = $fields[$key]['type'] == 'hidden' ? ' uk-hidden' : '';

            /**
             * Если есть иконка к полю
             */
            if (
                isset($fields[$key]['icon']) &&
                $fields[$key]['icon'] != ''
            ) {
                $input = '<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: ' . $fields[$key]['icon'] . '"></span>' . $input;
            }
            if (
                $fields[$key]['type'] == 'fieldset_checkbox'
            ) {
                $formConstruct .= $this->fieldsetCheckbox($fields[$key]);
            } else {
                $formConstruct .= '
                <div class="uk-margin-small-top">
                    <div class="filters-div ' . $hidden . '">
                        <label class="uk-text-small"
                            for="' . $fields[$key]['name'] . '">' . $fields[$key]['label'] . $requiredStar . '
                        </label>
                    </div>
                    <div class="uk-inline uk-width-1-1">
                    ' . $input . '
                    </div>
                </div>';
            }

            unset($input, $hidden);
        }

        return $formConstruct;
    }

    private function fieldsetCheckbox(array $field): string
    {
        /**
         * Get real fields values
         */
        $getFieldsArray = DB::getI()->getColumn(
            [
                'table_name'           => 'item_' . $field['name'],
                'field_name'           => $field['name'],
                'where'                => ParamsToSql::getSql(
                    $where = ['item_controller_id' => Item::getI()->currControllerId()]
                ),
                'order_by_field_name'  => 'item_id',
                'order_by_direction'   => 'ASC',
                'offset'               => 0,
                'limit'                => 0,
                'array'                => $where,
            ]
        );

        $getFieldsArray = $getFieldsArray != [] ? array_count_values($getFieldsArray) : [];

        ksort($getFieldsArray);

        if ($getFieldsArray != []) {
            $allFieldValues = array_flip(require $field['fields_path']);
            $fieldValue = $field['value'] == '' ? [] : $field['value'];
            $required = $field['required'] === true ? ' *' : '';
            $return = '';
            $return .= '
            <ul uk-accordion>
                <li>
                    <a class="uk-accordion-title" href="#">' . $field['label'] . $required . '</a>
                    <div class="uk-accordion-content">
                        <fieldset id="' . $field['name'] . '"><div class="uk-child-width-1-2 uk-grid-small" uk-grid>';

            foreach ($getFieldsArray as $key => $value) {
                $checked = in_array($key, $fieldValue) ? ' checked="checked"' : '';
                $return .= '<div><input type="checkbox" id="' . $field['name'] . $key . '" name="' . $field['name'] . '[]" value="' . $key . '"' . $checked . ' class="uk-hidden">';
                $return .= '<label class="fieldset-label uk-button uk-button-default uk-width-1-1" for="' . $field['name'] . $key . '">' . Trl::_($allFieldValues[$key]) . '</label></div>';
            }
            unset($key, $value);

            $return .= '</div></fieldset></div></li></ul>';

            return $return;
            #
        } else {
            return '';
        }
    }
}
