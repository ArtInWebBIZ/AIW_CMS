<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\View;

defined('AIW_CMS') or die;

class OneFieldsConstruct
{
    public function getFieldConstruct(array $fields)
    {
        require PATH_INC . 'formUk.php';

        $formConstruct = '';

        foreach ($fields as $key => $value) {

            if ($fields[$key] === null) {
                continue;
            }

            $disabled    = $fields[$key]['disabled'] ? ' disabled' : '';
            $required    = $fields[$key]['required'] ? ' required' : '';
            $minlength   = $fields[$key]['minlength'] == '' ? '' : ' minlength="' . $fields[$key]['minlength'] . '"';
            $maxlength   = $fields[$key]['maxlength'] == '' ? '' : ' maxlength="' . $fields[$key]['maxlength'] . '"';
            $placeholder = isset($fields[$key]['placeholder']) && $fields[$key]['placeholder'] != '' ? ' placeholder="' . $fields[$key]['placeholder'] . '"' : '';
            $class       = $fields[$key]['class'] == '' ? '' : ' class="' . $fields[$key]['class'] . '"';

            if (
                $fields[$key]['type'] == 'text' ||
                $fields[$key]['type'] == 'email' ||
                $fields[$key]['type'] == 'hidden' ||
                $fields[$key]['type'] == 'password'
            ) {

                $value = $fields[$key]['value'] == '' ? '' : ' value="' . $fields[$key]['value'] . '"';
                $input = '
                    <input type="' . $fields[$key]['type'] . '" name="' . $fields[$key]['name'] . '" ' . $required . ' id="' . $fields[$key]['name'] . '" ' . $minlength . $maxlength . $class . $disabled . $placeholder . $value . '>';
            } elseif (
                $fields[$key]['type'] == 'select'
            ) {

                $input = '
                    <select name="' . $fields[$key]['name'] . '" ' . $required . ' id="' . $fields[$key]['name'] . '" ' . $class . $disabled . '>
                        ' . $fields[$key]['value'] . '
                    </select>';
            } elseif (
                $fields[$key]['type'] == 'file'
            ) {

                $input = '
                    <div class="js-upload" uk-form-custom="target: true">
                        <input type="' . $fields[$key]['type'] . '" name="' . $fields[$key]['name'] . '" ' . $required . ' id="' . $fields[$key]['name'] . '"' . $disabled . ' multiple>
                            <input class="uk-input uk-form-width-medium" type="text" ' . $placeholder . ' disabled>
                    </div>';
            } elseif (
                $fields[$key]['type'] == 'checkbox'
            ) {

                $input = '
                    <input type="' . $fields[$key]['type'] . '" name="' . $fields[$key]['name'] . '" id="' . $fields[$key]['name'] . '" ' . $class . ' value="' . $fields[$key]['value'] . '"' . (isset($fields[$key]['checked']) && $fields[$key]['checked'] === true ? ' checked="checked"' : '') . $disabled . '>';
            } elseif (
                $fields[$key]['type'] == 'textarea'
            ) {
                $input = '
                <textarea name="' . $fields[$key]['name'] . '" onkeyup="textCounter(this,\'counter\',' . $fields[$key]['maxlength'] . ');" id="' . $fields[$key]['name'] . '" ' . $class . ' rows="' . $fields[$key]['rows'] . '" ' . $minlength . $maxlength . $placeholder . '>' . $fields[$key]['value'] . '</textarea>
                <input class="uk-form-blank" disabled maxlength="3" size="3" value="' . $fields[$key]['maxlength'] . '" id="counter">
                <script>
                    function textCounter(field, field2, maxlimit) {
                        var countfield = document.getElementById(field2);
                        if (field.value.length > maxlimit) {
                            field.value = field.value.substring(0, maxlimit);
                            return false;
                        } else {
                            countfield.value = maxlimit - field.value.length;
                        }
                    }
                </script>';
            }

            $requiredStar = ($fields[$key]['required']) ? '&nbsp;*' : '';

            $hidden = $fields[$key]['type'] == 'hidden' ? ' uk-hidden' : '';

            /**
             * Если есть иконка к полю
             */
            if (isset($fields[$key]['icon'])) {
                $ukInputDiv = $ukInputDiv . ' uk-inline';
                $input      = '<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: ' . $fields[$key]['icon'] . '"></span>
                ' . $input;
            } elseif ($fields[$key]['type'] == 'textarea') {
                $ukInputDiv = 'uk-width-1-1 uk-text-center';
            }

            $formConstruct .= '
                <div class="' . $ukInputDiv . '">
                ' . $input . '
                </div>';

            unset($input, $hidden);
        }

        return $formConstruct;
    }
}
