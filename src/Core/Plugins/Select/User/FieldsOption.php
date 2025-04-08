<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\User;

defined('AIW_CMS') or die;

use Core\Plugins\Name\UserEditFields;
use Core\Trl;

class FieldsOption
{
    private static $instance  = null;
    private static $allFields = 'null';

    private function __construct()
    {
    }

    public static function getI(): FieldsOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllFields()
    {
        if (self::$allFields == 'null') {
            self::$allFields = require PATH_INC . 'user' . DS . 'fields.php';
        }

        return self::$allFields;
    }

    public function fieldsOptionClear()
    {
        return self::getAllFields();
    }

    public function fieldsOptionHtml($editedField = 'null')
    {
        $variable = self::getAllFields();

        $selected = $editedField == 'null' ? ' selected="selected"' : '';

        $fieldsOptionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $key === $editedField ? ' selected="selected"' : '';
            $fieldsOptionHtml .= '
            <option value="' . $key . '"' . $selected . '>' . UserEditFields::getName($key) . '</option>';
        }
        unset($key, $value);

        return $fieldsOptionHtml;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
