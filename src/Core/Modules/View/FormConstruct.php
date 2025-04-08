<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\View;

use Core\Trl;

defined('AIW_CMS') or die;

class FormConstruct
{
    public function getFormConstruct(array $fields)
    {
        require PATH_INC . 'formUk.php';

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
            $info        = !isset($fields[$key]['info']) || $fields[$key]['info'] == '' ? '' : ' <a href="#' . $fields[$key]['name'] . '-modal" uk-icon="icon: info" class="c-gold" uk-toggle></a>';
            $modalDiv    = !isset($fields[$key]['info']) || $fields[$key]['info'] == '' ? '' : '
                <div id="' . $fields[$key]['name'] . '-modal" class="uk-flex-top" uk-modal>
                    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <p>' . $fields[$key]['info'] . '</p>
                    </div>
                </div>';
            $class = !isset($fields[$key]['class']) || $fields[$key]['class'] == '' ? '' : ' class="' . $fields[$key]['class'] . ' input-shadow"';

            if (
                $fields[$key]['type'] == 'text' ||
                $fields[$key]['type'] == 'date' ||
                $fields[$key]['type'] == 'email' ||
                $fields[$key]['type'] == 'hidden' ||
                $fields[$key]['type'] == 'password'
            ) {

                $value = $fields[$key]['value'] == '' ? '' : ' value="' . $fields[$key]['value'] . '"';
                $input = '
                    <input type="' . $fields[$key]['type'] . '" name="' . $fields[$key]['name'] . '" ' . $required . ' id="' . $fields[$key]['name'] . '" ' . $minlength . $maxlength . $class . $disabled . $placeholder . $value . '>';
            }
            /**
             * If input type select
             */
            elseif (
                $fields[$key]['type'] == 'select'
            ) {

                $input = '
                    <select name="' . $fields[$key]['name'] . '" ' . $required . ' id="' . $fields[$key]['name'] . '" ' . $class . $disabled . '>
                        ' . $fields[$key]['value'] . '
                    </select>';
            }
            /**
             * If input type file
             */
            elseif (
                $fields[$key]['type'] == 'file'
            ) {
                $input = '
                    <div class="js-upload" uk-form-custom="target: true">
                        <input type="' . $fields[$key]['type'] . '" name="' . $fields[$key]['name'] . '"
                            ' . $required . ' id="' . $fields[$key]['name'] . '"' . $disabled . ' multiple>
                        <input class="uk-input uk-form-width-medium input-shadow" type="text" ' . $placeholder . ' disabled>
                    </div>';
            }
            /**
             * If input type file
             */
            elseif (
                $fields[$key]['type'] == 'multiple'
            ) {
                $input = '
                    <div class="js-upload" uk-form-custom="target: true">
                        <input type="file" name="' . $fields[$key]['name'] . '[]"
                            ' . $required . ' id="' . $fields[$key]['name'] . '"' . $disabled . ' multiple>
                        <input class="uk-input uk-form-width-medium" type="text" ' . $placeholder . ' disabled>
                    </div>';
            }
            /**
             * If input type file
             */
            elseif (
                $fields[$key]['type'] == 'drag_and_drop'
            ) {
                $input = '
                    <div class="js-upload uk-placeholder uk-text-center">
                        <span uk-icon="icon: thumbnails"></span>
                        <span class="uk-text-middle">' . Trl::_('PHOTO_ATTACH_MULTIPLE_PHOTO') . '</span><br>
                        <span class="uk-text-meta">' . Trl::_('PHOTO_UP_TO_10_PHOTOS') . '</span><br>
                        <div uk-form-custom>
                            <input type="file" name="' . $fields[$key]['name'] . '[]"
                            ' . $required . ' id="' . $fields[$key]['name'] . '"' . $disabled . ' multiple>
                            <span class="uk-text-primary">' . Trl::_('PHOTO_ATTACH_SELECTING_ONE') . '</span>
                        </div>
                    </div>
                    <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>';
                ob_start();
                readfile(PATH_PUBLIC . 'js' . DS . 'js-progressbar.js');
                $input = $input . '<script>' . ob_get_clean() . '</script>';
            }
            /**
             * If input type checkbox
             */
            elseif (
                $fields[$key]['type'] == 'checkbox'
            ) {

                $input = '
                    <input
                        type="' . $fields[$key]['type'] . '"
                        name="' . $fields[$key]['name'] . '"
                        id="' . $fields[$key]['name'] . '"
                        ' . $class . '
                        value="' . $fields[$key]['value'] . '"' . (isset($fields[$key]['checked']) && $fields[$key]['checked'] === true ? ' checked="checked"' : '') . $disabled . '>';
            }
            /**
             * If input type textarea
             */
            elseif (
                $fields[$key]['type'] == 'textarea'
            ) {
                $input = '<textarea name="' . $fields[$key]['name'] . '"
                    onkeyup="textCounter(this,\'' . $fields[$key]['name'] . '_counter\',' . $fields[$key]['maxlength'] . ');"
                    id="' . $fields[$key]['name'] . '" ' . $class . ' rows="' . $fields[$key]['rows'] . '"
                    ' . $minlength . $maxlength . $placeholder . '>' . $fields[$key]['value'] . '</textarea>
                    <input id="' . $fields[$key]['name'] . '_counter" class="uk-form-blank uk-text-center" disabled maxlength="3" size="9" value="' . $fields[$key]['maxlength'] . '">
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
             * If there is an icon for the field
             */
            $ukInputDiv = 'uk-width-1-1 uk-width-expand@s';

            if (isset($fields[$key]['icon'])) {
                $ukInputDiv = $ukInputDiv . ' uk-inline';
                $input      = '
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: ' . $fields[$key]['icon'] . '"></span>
                    ' . $input;
            }

            if ($fields[$key]['type'] == 'textarea') {
                $ukInputDiv = 'uk-width-1-1 uk-text-center uk-margin-small-top';
            }

            $labelHidden = $fields[$key]['label'] == '' ? ' uk-hidden' : '';

            if (
                $fields[$key]['type'] == 'fieldset_checkbox'
            ) {
                $formConstruct .= $this->fieldsetCheckbox($fields[$key]);
            } else {
                $formConstruct .= '
                    <div class="' . $ukGrid . $hidden . '" uk-grid>
                        <div class="' . $ukLabelDiv . $labelHidden . '">
                            <label for="' . $fields[$key]['name'] . '" class="' . $ukLabel . '">
                                ' . $fields[$key]['label'] . $requiredStar . $info . '
                            </label>
                        </div>
                        <div class="' . $ukInputDiv . '">
                        ' . $input . '
                        </div>
                    </div>'
                    . $modalDiv;
            }


            unset($input, $hidden);
        }

        return $formConstruct;
    }

    private function fieldsetCheckbox(array $field): string
    {
        if (is_readable($field['fields_path'])) {
            $getFieldsArray = require $field['fields_path'];
            $fieldValue = $field['value'] == '' ? [] : $field['value'];
            $required = $field['required'] === true ? ' *' : '';
            $return = '';
            $return .= '
            <div class="uk-flex-middle uk-margin-top">
            <ul uk-accordion>
                <li>
                    <a class="uk-accordion-title input-shadow" href="#">' . $field['label'] . $required . '</a>
                    <div class="uk-accordion-content">
                        <fieldset id="' . $field['name'] . '"><div class="uk-child-width-1-2 uk-grid-small" uk-grid>';

            foreach ($getFieldsArray as $key => $value) {
                $checked = in_array($value, $fieldValue) ? ' checked="checked"' : '';
                $return .= '<div><input type="checkbox" id="' . $field['name'] . $value . '" name="' . $field['name'] . '[]" value="' . $value . '"' . $checked . ' class="uk-hidden">';
                $return .= '<label class="fieldset-label uk-button uk-width-1-1" for="' . $field['name'] . $value . '">' . Trl::_($key) . '</label></div>';
            }

            $return .= '</div></fieldset></div></li></ul>';

            return $return;
            #
        } else {
            return '';
        }
    }
}
