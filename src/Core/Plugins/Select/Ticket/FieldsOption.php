<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Select\Ticket;

defined('AIW_CMS') or die;

use Core\Plugins\Name\TicketEditFields as Tef;
use Core\Trl;

class FieldsOption
{
    private static $instance  = null;
    private static $allFields = null;

    private function __construct() {}

    public static function getI(): FieldsOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllFields(): array
    {
        if (self::$allFields === null) {
            self::$allFields = require PATH_INC . 'ticket' . DS . 'fields.php';
        }

        return self::$allFields;
    }

    public function fieldsOptionClear()
    {
        return self::getAllFields();
    }

    public function fieldsOptionHtml($fieldsName = 'null')
    {
        $variable = self::getAllFields();

        $selected = $fieldsName == 'null' ? ' selected="selected"' : '';

        $brandFieldsOptionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value === $fieldsName ? ' selected="selected"' : '';
            $brandFieldsOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Tef::getName($value) . '</option>';
        }

        return $brandFieldsOptionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
