<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Select\Review;

defined('AIW_CMS') or die;

use Core\Plugins\Name\Review\Fields as Name;
use Core\Trl;

class Fields
{
    private static $instance  = null;
    private static $allFields = null;

    private function __construct() {}

    public static function getI(): Fields
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllFields(): array
    {
        if (self::$allFields === null) {
            self::$allFields = require PATH_INC . 'review' . DS . 'fields.php';
        }

        return self::$allFields;
    }

    public function clear()
    {
        return self::getAllFields();
    }

    public function option($editedField = 'null')
    {
        $variable = self::getAllFields();

        $selected = $editedField == 'null' ? ' selected="selected"' : '';

        $fieldsOptionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value === $editedField ? ' selected="selected"' : '';
            $fieldsOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Name::getName($value) . '</option>';
        }

        return $fieldsOptionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
