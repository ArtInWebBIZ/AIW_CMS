<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Balance;

defined('AIW_CMS') or die;

use Core\Plugins\Name\Balance\TypeCode;
use Core\Trl;

class TypeCodeOption
{
    private static $instance        = null;
    private static $allContentTypes = 'null';

    private function __construct()
    {
    }

    public static function getI(): TypeCodeOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllContentTypes()
    {
        if (self::$allContentTypes == 'null') {
            self::$allContentTypes = require PATH_INC . 'balance' . DS . 'contentType.php';
        }

        return self::$allContentTypes;
    }

    public function clear()
    {
        return self::getAllContentTypes();
    }

    public function option($typeCode = 'null')
    {
        $variable = self::getAllContentTypes();

        $typeCode = $typeCode === 'null' ? $typeCode : (int) $typeCode;
        $selected = $typeCode === 'null' ? ' selected="selected"' : '';

        $html = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = (int) $value === $typeCode ? ' selected="selected"' : '';
            $html .= '<option value="' . $value . '"' . $selected . '>' . TypeCode::getName($value) . '</option>';
        }

        return $html;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
