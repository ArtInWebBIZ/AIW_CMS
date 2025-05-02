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
        if (self::$allStatus === null) {
            self::$allStatus = require ForAll::compIncPath('Ticket', 'status');
        }

        return self::$allStatus;
    }

    public function clear()
    {
        return self::getAllStatus();
    }

    public function option($ticketStatus = null)
    {
        return OptionTpl::labelFromKey(self::getAllStatus(), $ticketStatus);
    }

    private function __clone() {}
    public function __wakeup() {}
}
