<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Ticket\Lib\Select;

defined('AIW_CMS') or die;

use App\Contacts\Index\Req\Func;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\Select\OptionTpl;

class Type
{
    private static $instance      = null;
    private static $allType       = null;
    private static $contactsClear = null;

    private function __construct() {}

    public static function getI(): Type
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * @return array
     */
    private static function getAllTypes(): array
    {
        if (self::$allType === null) {
            self::$allType = require ForAll::compIncPath('Ticket', 'type');
        }

        return self::$allType;
    }

    public function clear()
    {
        return self::getAllTypes();
    }

    public function option($ticketType = null): string
    {
        return OptionTpl::labelFromKey(self::clear(), $ticketType);
    }

    public function toContactsClear()
    {
        if (self::$contactsClear === null) {

            $clear = [];

            foreach (self::getAllTypes() as $key => $value) {

                if (Func::getI()->checkAccess() === 'true') {
                    $clear[$key] = self::getAllTypes()[$key];
                }
            }

            self::$contactsClear = $clear;
        }

        return self::$contactsClear;
    }

    public function toContactsOption($ticketType = null)
    {
        return OptionTpl::labelFromKey(self::toContactsClear(), $ticketType);
    }

    private function __clone() {}
    public function __wakeup() {}
}
