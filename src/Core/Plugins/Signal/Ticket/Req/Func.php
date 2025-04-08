<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Signal\Ticket\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

class Func
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';

    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() === 1 &&
                Auth::getUserGroup() > 2
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private $countTickets = 'null';

    public function countTickets()
    {
        if ($this->countTickets == 'null') {

            if (Auth::getUserGroup() === 3) {
                $ticketType = [3];
            } elseif (Auth::getUserGroup() === 4) {
                $ticketType = [1, 4];
            } else {
                $ticketType = [5, 6];
            }

            $in    = ParamsToSql::getInSql($ticketType);
            $where = ['ticket_status' => 0];

            $this->countTickets = (int) DB::getI()->countFields(
                [
                    'table_name' => 'ticket',
                    'field_name' => 'id',
                    'where'      => '`ticket_type`' . $in['in'] . ' AND ' . ParamsToSql::getSql($where),
                    'array'      => array_merge($in['array'], $where),
                ]
            );
        }

        return $this->countTickets;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
