<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\User\Lib\Select;

defined('AIW_CMS') or die;

use Core\Plugins\Lib\ForAll;
use Core\Plugins\Select\OptionTpl;

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
            self::$allFields = array_flip(require ForAll::compIncPath('User', 'fields'));
        }

        return self::$allFields;
    }

    public function fieldsOptionClear()
    {
        return self::getAllFields();
    }

    public function fieldsOptionHtml($editedField = null)
    {
        return OptionTpl::labelFromKey($this->fieldsOptionClear(), $editedField);
    }

    private function __clone() {}
    public function __wakeup() {}
}
