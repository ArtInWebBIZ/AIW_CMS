<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Ticket;

defined('AIW_CMS') or die;

use Core\{
    Auth,
    Config,
    Trl
};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Name\TicketType as Ttn;
use App\Contacts\Index\Req\Func;

class TypeOption
{
    private static $instance      = null;
    private static $allType       = null;
    private static $contactsClear = [];

    private function __construct() {}

    public static function getI(): TypeOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Undocumented function
     * @return array
     */
    private static function getAllTypes(): array
    {
        if (self::$allType === null) {
            self::$allType = require PATH_INC . 'ticket' . DS . 'type.php';
        }

        return self::$allType;
    }

    public function clear()
    {
        return self::getAllTypes();
    }

    public function option($ticketType = 'null')
    {
        $selected = $ticketType == 'null' ? ' selected="selected"' : '';

        $ticketTypeOptionHtml = '<option value=""' . $selected . '>' . Trl::_('TICKET_TYPE_NOT_SELECTED') . '</option>';

        foreach (self::clear() as $key => $value) {
            $selected = $value === $ticketType ? ' selected="selected"' : '';
            $ticketTypeOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Ttn::getTypeName($value) . '</option>';
        }

        return $ticketTypeOptionHtml;
    }

    public function toContactsClear()
    {
        if (self::$contactsClear == []) {

            foreach (self::getAllTypes() as $key => $value) {

                if (
                    Func::getI()->checkAccess() !== 'true'
                ) {

                    continue;
                    #
                } else {
                    $contactsClear[$key] = self::getAllTypes()[$key];
                }
            }

            self::$contactsClear = $contactsClear;
        }

        return self::$contactsClear;
    }

    public function toContactsOption($ticketType = 0)
    {
        $selected = $ticketType == 0 ? ' selected="selected"' : '';

        $ticketTypeOptionHtml = '<option value=""' . $selected . '>' . Trl::_('TICKET_TYPE_NOT_SELECTED') . '</option>';

        foreach (self::toContactsClear() as $key => $value) {
            $selected = $value === $ticketType ? ' selected="selected"' : '';
            $ticketTypeOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Ttn::getTypeName($value) . '</option>';
        }

        return $ticketTypeOptionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
