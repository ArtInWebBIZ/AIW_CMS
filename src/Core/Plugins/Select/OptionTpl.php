<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Select;

use Core\Trl;

defined('AIW_CMS') or die;

class OptionTpl
{
    /**
     * Get option to html tag select where label get from array key
     * @param array $array
     * @param mixed $currentValue
     * @return string
     */
    public static function labelFromKey(array $array, mixed $currentValue = null): string
    {
        $option = '';

        if ($array !== []) {

            $selected = $currentValue === null ? ' selected="selected"' : '';

            $option = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

            foreach ($array as $key => $value) {
                $selected = $value == $currentValue ? ' selected="selected"' : '';
                $option .= '
                <option value="' . $value . '"' . $selected . '>' . Trl::_($key) . '</option>';
            }
        }

        return $option;
    }
    /**
     * Get option to html tag select where label get from array value
     * @param array $array
     * @param mixed $currentValue
     * @return string
     */
    public static function labelFromValue(array $array, mixed $currentValue = null): string
    {
        $option = '';

        if ($array !== []) {

            $selected = $currentValue === null ? ' selected="selected"' : '';

            $option = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

            foreach ($array as $key => $value) {
                $selected = $value == $currentValue ? ' selected="selected"' : '';
                $option .= '
            <option value="' . $value . '"' . $selected . '>' . Trl::_($value) . '</option>';
            }
        }

        return $option;
    }
}
