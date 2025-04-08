<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Excursion;

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;
use Core\Trl;

class Transport
{
    private static $instance  = null;
    private static $allValues = null;

    private function __construct() {}

    public static function getI(): Transport
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllValues(): array
    {
        if (self::$allValues == null) {
            self::$allValues = require PATH_INC . 'excursion' . DS . 'transport.php';;
        }

        return self::$allValues;
    }

    public function clear()
    {
        return self::getAllValues();
    }

    public function option($editedField = 'null')
    {
        $clear = self::getAllValues();

        $selected = $editedField == 'null' ? ' selected="selected"' : '';

        $optionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($clear as $key => $value) {
            $selected = $value == $editedField ? ' selected="selected"' : '';
            $optionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Trl::_($key) . '</option>';
        }

        return $optionHtml;
    }

    public function clearForm()
    {
        if (GroupAccess::check([3, 4, 5])) {
            return self::getAllValues();
        } else {
            $statusList = [];
            foreach (self::getAllValues() as $key => $value) {
                if (
                    $value === 0 ||
                    $value === 1
                ) {
                    $statusList[$key] = $value;
                } else {
                    continue;
                }
            }
            return $statusList;
        }
    }

    public function optionForm($editedField = 'null')
    {
        $clear = $this->clearForm();

        $selected = $editedField == 'null' ? ' selected="selected"' : '';

        $optionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($clear as $key => $value) {
            $selected = $value == $editedField ? ' selected="selected"' : '';
            $optionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Trl::_($key) . '</option>';
        }

        return $optionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
