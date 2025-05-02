<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Ticket\Lib\Select;

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
            self::$allFields = require ForAll::compIncPath('Ticket', 'fields');
        }

        return self::$allFields;
    }

    public function fieldsOptionClear()
    {
        return self::getAllFields();
    }

    public function fieldsOptionHtml($fieldsName = null)
    {
        return OptionTpl::labelFromKey(self::getAllFields(), $fieldsName);
    }

    private function __clone() {}
    public function __wakeup() {}
}
