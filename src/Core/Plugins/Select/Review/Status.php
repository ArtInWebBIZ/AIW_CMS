<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Review;

defined('AIW_CMS') or die;

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
            self::$allStatus = require PATH_INC . 'review' . DS . 'status.php';
        }

        return self::$allStatus;
    }

    public function clear()
    {
        return self::getAllStatus();
    }

    public function option($status = null)
    {
        $variable = $this->clear();

        $status = $status === null ? $status : (int) $status;

        $selected = $status === null ? ' selected="selected"' : '';

        $statusHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $value = (int) $value;
            $selected = $value === $status ? ' selected="selected"' : '';
            $statusHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Trl::_($key) . '</option>';
        }

        return $statusHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
