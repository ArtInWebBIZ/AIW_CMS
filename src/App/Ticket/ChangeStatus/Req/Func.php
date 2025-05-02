<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Ticket\ChangeStatus\Req;

defined('AIW_CMS') or die;

use Comp\Ticket\Lib\Ticket;
use Core\Auth;
use Core\Plugins\Check\CheckForm;
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Lib\ForAll;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $formCheck       = [];
    private $getTicket       = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check users access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() == 1 &&
                (
                    /**
                     * If other user groups have access to tickets management
                     * EDIT & UNCOMMENTS THIS
                     */
                    // (
                    //     GroupAccess::check([2]) &&
                    //     (int) $this->getTicket()['ticket_type'] === 3
                    // ) ||
                    GroupAccess::check([5])
                )
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Check ticket status form
     * if error isset key ['msg']
     * @return array
     */
    public function formCheck(): array
    {
        if ($this->formCheck === []) {
            $this->formCheck = CheckForm::check(ForAll::contIncPath() . 'fields.php');
        }

        return $this->formCheck;
    }
    /**
     * Change ticket`s status
     * @return boolean
     */
    public function changeTicketStatus(): bool
    {
        return Ticket::getI()->updateTicket(
            [
                'set'   => [
                    'ticket_status' => $this->formCheck()['ticket_status'],
                    'edited'        => time(),
                    'editor_id'     => Auth::getUserId(),
                ],
                'where' => ['id' => $this->formCheck()['id']],
            ]
        );
    }
    /**
     * Save change tickets status to log
     * if error - return zero (0)
     * @return integer
     */
    public function saveChangeTicketStatusToLog(): int
    {
        return Ticket::getI()->saveToEditLog(
            [
                'ticket_id'    => $this->formCheck()['id'],
                'ticket_type'  => $this->getTicket()['ticket_type'],
                'editor_id'    => Auth::getUserId(),
                'edited_field' => 'ticket_status',
                'old_value'    => $this->getTicket()['ticket_status'],
                'new_value'    => $this->formCheck()['ticket_status'],
                'edited'       => time(),
            ]
        );
    }
    /**
     * Get in array current ticket
     * @return array|false
     */
    public function getTicket(): array|false
    {
        if ($this->getTicket === 'null') {

            $this->getTicket = Ticket::getI()->getTicket(
                [
                    'id' => $this->formCheck()['id'],
                ]
            );
        }

        return $this->getTicket;
    }

    private function __clone() {}
    public function __wakeup() {}
}
