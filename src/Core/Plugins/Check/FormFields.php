<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\{Clean, GV, Session, Trl};
use Core\Plugins\Msg;

class FormFields
{
    private $field = null;
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    public function getCheckFields(array $fieldArr): array
    {
        foreach ($fieldArr as $key => $value) {

            if (
                $fieldArr[$key] === null ||
                $fieldArr[$key]['disabled'] === true
            ) {
                continue;
            }

            if (
                $fieldArr[$key]['type'] == 'text' ||
                $fieldArr[$key]['type'] == 'date' ||
                $fieldArr[$key]['type'] == 'email' ||
                $fieldArr[$key]['type'] == 'password' ||
                $fieldArr[$key]['type'] == 'checkbox' ||
                $fieldArr[$key]['type'] == 'textarea'
            ) {

                if (
                    $fieldArr[$key]['type'] == 'checkbox' &&
                    !isset(GV::post()[$key])
                ) {
                    $postValue = 0;
                } elseif (trim(strval(GV::post()[$key])) == '') {
                    $postValue = '';
                } else {
                    $postValue = $this->clean($fieldArr[$key]);
                }

                if (!isset($postValue) || $postValue === false) {
                    $this->getFieldsMsg($fieldArr, $key);
                } elseif ($fieldArr[$key]['clean'] == 'time') {

                    if (is_int($postValue)) {
                        $this->field[$key] = $postValue - (gettimeofday()['minuteswest'] * 60) - Session::getTimeDifference();
                    } else {
                        $this->field[$key] = $postValue;
                    }
                    #
                } else {

                    if ($this->fieldLength($key, $postValue, $fieldArr) === true) {
                        $this->field[$key] = $postValue;
                    } else {
                        $this->getFieldsMsg($fieldArr, $key);
                    }
                }
            }
            /**
             * If fields type is select or hidden
             */
            elseif (
                $fieldArr[$key]['type'] == 'select' ||
                $fieldArr[$key]['type'] == 'hidden'
            ) {

                if (trim(strval(GV::post()[$key])) == '') {
                    $postValue = '';
                } else {
                    $postValue = $this->clean($fieldArr[$key]);
                }

                if (
                    ( #
                        $fieldArr[$key]['required'] === true &&
                        $fieldArr[$key]['type'] == 'select' &&
                        !in_array($postValue, $fieldArr[$key]['check'])
                    ) ||
                    $postValue === false
                ) {
                    $this->getFieldsMsg($fieldArr, $key);
                } else {
                    $this->field[$key] = $postValue;
                }
            }
            /**
             * If fields type is file
             * @return string // or isset fields error
             * @return array // or not isset fields error
             */
            elseif ($fieldArr[$key]['type'] == 'file') {

                if (
                    $fieldArr[$key]['required'] === true &&
                    GV::files()[$key] === null
                ) {
                    $this->getFieldsMsg($fieldArr, $key);
                    #
                } else {

                    if (
                        GV::files()[$key] === null ||
                        GV::files()[$key]['size'] == 0
                    ) {
                        unset($this->field[$key]);
                    } else {

                        $postValue = GV::files()[$key];

                        $parts = pathinfo($postValue['name']);

                        if (
                            !in_array(strtolower($parts['extension']), $fieldArr[$key]['allow_file_type']) ||
                            in_array(strtolower($parts['extension']), $fieldArr[$key]['deny_file_type']) ||
                            $postValue['tmp_name'] == 'none' ||
                            !is_uploaded_file($postValue['tmp_name']) ||
                            empty($postValue['name']) ||
                            (int) $postValue['size'] > (int) $fieldArr[$key]['max_file_size']
                        ) {
                            $this->getFieldsMsg($fieldArr, $key);
                            $this->field[$key] = false;
                            break;
                        } elseif ($postValue['error'] > 0) {
                            $this->fileError($postValue);
                            $this->field[$key] = false;
                        } elseif ((int) $postValue['size'] > (int) $fieldArr[$key]['max_file_size']) {
                            $this->getFieldsMsg($fieldArr, $key);
                        } else {
                            $this->field[$key] = $postValue;
                        }
                    }
                }
            }
            /**
             * If fields type is multiple
             * @return string // or isset fields error
             * @return array // or not isset fields error
             */
            elseif ($fieldArr[$key]['type'] == 'multiple') {

                if ($fieldArr[$key]['required'] === true && GV::files()[$key] === null) {
                    $this->getFieldsMsg($fieldArr, $key);
                } else {

                    if (GV::files()[$key] !== null) {

                        foreach (GV::files()[$key] as $k => $l) {
                            foreach ($l as $i => $v) {
                                $multiple[$i][$k] = $v;
                            }
                        }
                        unset($k, $l);
                        unset($i, $v);

                        foreach ($multiple as $key1 => $value1) {

                            $parts = pathinfo($multiple[$key1]['name']);

                            if (
                                !in_array(strtolower($parts['extension']), $fieldArr[$key]['allow_file_type']) ||
                                in_array(strtolower($parts['extension']), $fieldArr[$key]['deny_file_type']) ||
                                $multiple[$key1]['tmp_name'] == 'none' ||
                                !is_uploaded_file($multiple[$key1]['tmp_name']) ||
                                empty($multiple[$key1]['name']) ||
                                (int) $multiple[$key1]['size'] > (int) $fieldArr[$key]['max_file_size']
                            ) {
                                $this->getFieldsMsg($fieldArr, $key);
                                $this->field[$key] = false;
                                break;
                            } elseif ($multiple[$key1]['error'] > 0) {
                                $this->fileError($multiple[$key1]);
                                $this->field[$key] = false;
                                break;
                            } else {
                                $this->field[$key][$key1] = $multiple[$key1];
                            }
                        }
                        unset($key1, $value1);
                        #
                    } else {
                        $this->field[$key] = [];
                    }
                }
            }
            /**
             * If fields type is fieldset_checkbox
             * @return string // or isset fields error
             * @return array // or not isset fields error
             */
            elseif ($fieldArr[$key]['type'] == 'fieldset_checkbox') {

                if (
                    $fieldArr[$key]['required'] === true &&
                    ( #
                        !isset(GV::post()[$key]) ||
                        !is_array(GV::post()[$key])
                    )
                ) {
                    $this->getFieldsMsg($fieldArr, $key);
                } else {

                    if (
                        !isset(GV::post()[$key]) ||
                        !is_array(GV::post()[$key])
                    ) {
                        continue;
                    } else {
                        /**
                         * Get fieldset array
                         */
                        $fieldsetList = array_flip(require $fieldArr[$key]['fields_path']);
                        /**
                         * Check values from $_POST
                         */
                        foreach (GV::post()[$key] as $key2 => $value2) {
                            /**
                             * Check value type
                             */
                            $value2 = Clean::int($value2);
                            /**
                             * Check values from $_POST in fieldset array file
                             */
                            if (
                                !isset($fieldsetList[$value2])
                            ) {
                                $this->getFieldsMsg($fieldArr, $key);
                                $this->field[$key] = false;
                                break;
                            } else {
                                $this->field[$key][$key2] = $value2;
                            }
                        }
                        unset($key2, $value2);
                    }
                }
            }
        }

        if ($this->field === null) {
            $this->field['msg'] = 'MSG_FILE_WAS_NOT_LOADED';
        }

        return $this->field;
    }
    /**
     * Check fields length value
     * @param string $key
     * @param mixed  $postValue
     * @param array  $fieldArr
     * @return boolean
     */
    private function fieldLength(string $key, mixed $postValue, array $fieldArr): bool
    {
        if ($postValue !== false) {

            $postValue = (string) $postValue;

            if (
                $fieldArr[$key]['required'] === false &&
                $postValue == ''
            ) {

                return true;
                #
            } elseif (
                (
                    $fieldArr[$key]['minlength'] != '' &&
                    iconv_strlen($postValue) < (int) $fieldArr[$key]['minlength']
                ) ||
                (
                    $fieldArr[$key]['maxlength'] != '' &&
                    iconv_strlen($postValue) > (int) $fieldArr[$key]['maxlength']
                )
            ) {

                return false;
                #
            } else {
                return true;
            }
            #
        } else {
            return false;
        }
    }
    /**
     * Return fields errors message
     * @param array  $fieldArr
     * @param string $key
     * @return boolean
     */
    private function getFieldsMsg(array $fieldArr, string $key): bool
    {
        $msgText = Trl::_('INFO_NO_CORRECT_FIELD_VALUE') . '<br><strong>' . $fieldArr[$key]['label'] . '</strong><br><br>' . $fieldArr[$key]['info'];
        /**
         * If isset msg
         */
        if (!isset($this->field['msg'])) {
            $this->field['msg'] = Msg::getMsg_('warning', $msgText);
        }
        /**
         * If NOT isset msg
         */
        else {
            $this->field['msg'] .= Msg::getMsg_('warning', $msgText);
        }

        $this->field[$key] = false;

        return true;
    }
    /**
     * View file errors value
     * @param array $file
     * @return string
     */
    private function fileError(array $file): string
    {
        if ((int) $file['error'] > 0) {

            if (!isset($this->field['msg'])) {
                $this->field['msg'] = '';
            }

            switch (@$file['error']) {
                case 1:
                case 2:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_FILE_SIZE_EXCEEDED');
                    break;
                case 3:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_FILE_RECEIVED_PARTIALLY');
                    break;
                case 4:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_FILE_WAS_NOT_LOADED');
                    break;
                case 6:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_NO_TEMPORARY_DIRECTORY');
                    break;
                case 7:
                    $this->field['msg'] .= Msg::getMsgSprintf('danger', 'MSG_FAILED_WRITE_FILE_TO_DISK', ...[$file['name']]);
                    break;
                case 8:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_PHP_STOPPED_FILE_UPLOAD');
                    break;
                case 9:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_DIRECTORY_DOES_NOT_EXIST');
                    break;
                case 10:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_MAXIMUM_FILE_SIZE_EXCEEDED');
                    break;
                case 11:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_FILE_TYPE_IS_PROHIBITED');
                    break;
                case 12:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_ERROR_COPYING_FILE');
                    break;
                default:
                    $this->field['msg'] .= Msg::getMsg_('danger', 'MSG_UNKNOWN_ERROR');
                    break;
            }

            return $this->field['msg'];
        } else {
            return '';
        }
    }
    /**
     * Return correctly fields value or false
     * @param array $field
     * @return mixed
     */
    private function clean(array $field): mixed
    {
        $postValue = Clean::check(trim(GV::post()[$field['name']]), $field['clean']);

        return is_string($postValue) ? str_ireplace("https://", "", $postValue) : $postValue;
    }
}
