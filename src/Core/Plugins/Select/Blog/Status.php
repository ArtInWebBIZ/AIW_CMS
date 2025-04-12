<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Select\Blog;

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;
use Core\Trl;

class Status
{
    private static $instance  = null;
    private static $allStatus = null;

    private function __construct() {}

    public static function getI(): Status
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllStatus(): array
    {
        if (self::$allStatus == null) {
            self::$allStatus = require PATH_INC . 'blog' . DS . 'status.php';;
        }

        return self::$allStatus;
    }

    public function clear()
    {
        return self::getAllStatus();
    }

    public function option($editedField = 'null')
    {
        $clear = self::getAllStatus();

        $selected = $editedField == 'null' ? ' selected="selected"' : '';

        $languagesOptionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($clear as $key => $value) {
            $selected = $value == $editedField ? ' selected="selected"' : '';
            $languagesOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Trl::_($key) . '</option>';
        }

        return $languagesOptionHtml;
    }

    public function clearForm()
    {
        if (GroupAccess::check([5])) {
            return self::getAllStatus();
        } else {
            $statusList = [];
            foreach (self::getAllStatus() as $key => $value) {
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

        $languagesOptionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($clear as $key => $value) {
            $selected = $value == $editedField ? ' selected="selected"' : '';
            $languagesOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Trl::_($key) . '</option>';
        }

        return $languagesOptionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
