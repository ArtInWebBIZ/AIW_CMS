<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\User;

defined('AIW_CMS') or die;

use Core\Plugins\Name\UserStatus as Usn;
use Core\Trl;

class Type
{
    private static $instance  = null;
    private static $allType = 'null';
    private $checkToForm      = null;

    private function __construct()
    {
    }

    public static function getI(): Type
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllType()
    {
        if (self::$allType == 'null') {
            self::$allType = require PATH_INC . 'user' . DS . 'type.php';
        }

        return self::$allType;
    }

    public function clear()
    {
        return self::getAllType();
    }

    public function option($type = 'null')
    {
        $variable = $this->clear();

        $selected = $type === 'null' ? ' selected="selected"' : '';

        $optionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value == $type ? ' selected="selected"' : '';
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
