<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Ticket\ChangeStatus\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Dll\ForAll;
use Core\Plugins\Dll\Ticket;

class Func
{
    private static $instance = null;

    private function __construct() {}

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
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() == 1 &&
                (
                    (
                        GroupAccess::check([2]) &&
                        (int) $this->getTicket()['ticket_type'] === 3
                    ) ||
                    GroupAccess::check([5])
                )
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private $formCheck = [];

    public function formCheck()
    {
        if ($this->formCheck == []) {

            $this->formCheck = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require ForAll::contIncPath() . 'fields.php'
            );
        }

        return $this->formCheck;
    }

    public function changeTicketStatus()
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

    public function saveChangeTicketStatusToLog()
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

    private $getTicket = 'null';

    public function getTicket(): array | false
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
