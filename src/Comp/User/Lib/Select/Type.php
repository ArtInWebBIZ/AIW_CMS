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

class Type
{
    private static $instance  = null;
    private static $allType   = null;

    private function __construct() {}

    public static function getI(): Type
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllType()
    {
        if (self::$allType === null) {
            self::$allType = require ForAll::compIncPath('User', 'type');
        }

        return self::$allType;
    }

    public function clear()
    {
        return self::getAllType();
    }

    public function option($type = null)
    {
        return OptionTpl::labelFromKey($this->clear(), $type);
    }

    private function __clone() {}
    public function __wakeup() {}
}
