<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Other;

defined('AIW_CMS') or die;

use Core\Trl;

class NoYes
{
    private static $instance     = null;
    private static $all = 'null';

    private function __construct()
    {
    }

    public static function getI(): NoYes
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAll(): array
    {
        if (self::$all == 'null') {

            $all = require PATH_INC . 'other' . DS . 'noYes.php';

            foreach ($all as $key => $value) {
                $noYes[$key] = $value;
            }

            self::$all = $noYes;
        }

        return self::$all;
    }

    public function clear()
    {
        return self::getAll();
    }

    public function option($fieldValue = 'null')
    {
        $clear = $this->clear();

        $selected = $fieldValue == 'null' ? ' selected="selected"' : '';

        $optionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($clear as $key => $value) {
            $selected = $value == $fieldValue ? ' selected="selected"' : '';
            $optionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Trl::_($key) . '</option>';
        }

        return $optionHtml;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
