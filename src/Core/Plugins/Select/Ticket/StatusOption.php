<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Select\Ticket;

defined('AIW_CMS') or die;

use Core\Plugins\Name\TicketStatus as Tsn;
use Core\Trl;

class StatusOption
{
    private static $instance  = null;
    private static $allStatus = null;

    private function __construct() {}

    public static function getI(): StatusOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllStatus(): array
    {
        if (self::$allStatus === null) {
            self::$allStatus = require PATH_INC . 'ticket' . DS . 'status.php';
        }

        return self::$allStatus;
    }

    public function clear()
    {
        return self::getAllStatus();
    }

    public function option($ticketStatus = 'null')
    {
        $variable = self::getAllStatus();

        $selected = $ticketStatus == 'null' ? ' selected="selected"' : '';

        $ticketStatusOptionHtml = '<option value=""' . $selected . '>' . Trl::_('TICKET_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value === $ticketStatus ? ' selected="selected"' : '';
            $ticketStatusOptionHtml .= '<option value="' . $value . '"' . $selected . '>' . Tsn::getStatusName($value) . '</option>';
        }

        return $ticketStatusOptionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
