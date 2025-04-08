<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Check\Item;
use Core\Trl;

class AllFields
{
    private static $instance     = null;
    private static $allValues = null;
    private $clearForm = null;

    private function __construct() {}

    public static function getI(): AllFields
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllValues(): array
    {
        if (self::$allValues == null) {
            self::$allValues = Item::getI()->getAllItemFieldsList();
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
    /**
     * Return …
     * @return array
     */
    public function clearForm(): array
    {
        if ($this->clearForm == null) {

            if (GroupAccess::check([3, 4, 5])) {
                $this->clearForm = self::getAllValues();
            } else {
                $valuesList = [];
                foreach (self::getAllValues() as $key => $value) {
                    if (
                        $value === 0 ||
                        $value === 1
                    ) {
                        $valuesList[$key] = $value;
                    } else {
                        continue;
                    }
                }
                $this->clearForm = $valuesList;
            }
        }

        return $this->clearForm;
    }
    #
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
