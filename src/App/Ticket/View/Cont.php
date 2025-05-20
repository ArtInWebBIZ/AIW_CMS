<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Ticket\View;

defined('AIW_CMS') or die;

use App\Ticket\View\Req\Func;
use Core\{Auth, Content, Trl};
use Core\Plugins\{Msg, Ssl};
use Core\Plugins\Check\GroupAccess;

class Cont
{
    private $content = '';

    public function getContent()
    {
        $this->content = Content::getDefaultValue();

        $this->content['tpl']   = GroupAccess::check([5]) ? 'admin' : 'index';
        $this->content['title'] = Func::getI()->getTicketId() > 0 ?
            Trl::_('TICKET_NUMBER') . Func::getI()->getTicketId() : '';
        /**
         * We check whether there is a ticket with such ID
         */
        if (
            Func::getI()->getTicketId() > 0 &&
            Func::getI()->getTicket() !== false
        ) {
            /**
             * Check the user tolerance
             */
            if (Func::getI()->checkAccess() === true) {
                /**
                 * If the status of a ticket "has not yet been considered",
                 * and the user is a moderator
                 * We change the status of a ticket to "considered"
                 */
                if (
                    Auth::getUserStatus() == 1 &&
                    (int) Func::getI()->getTicket()['ticket_status'] === 0 &&
                    (
                        (
                            GroupAccess::check([2]) &&
                            (int) Func::getI()->getTicket()['ticket_type'] === 3
                        ) ||
                        (
                            GroupAccess::check([5]) &&
                            (
                                (int) Func::getI()->getTicket()['ticket_type'] === 4 ||
                                (int) Func::getI()->getTicket()['ticket_type'] === 5 ||
                                (int) Func::getI()->getTicket()['ticket_type'] === 6
                            )
                        )
                    )
                ) {

                    Func::getI()->changeTicketStatus();
                    Func::getI()->changeTicketResponsible();
                    /**
                     * Registering changes in the log of ticket changes
                     */
                    Func::getI()->saveChangeStatusToLog();

                    $this->content['redirect'] = Ssl::getLinkLang() . 'ticket/' . Func::getI()->getTicketId() . '.html';
                } elseif (
                    Func::getI()->getTicket()['responsible'] != 0 &&
                    GroupAccess::check([3]) &&
                    Func::getI()->getTicket()['responsible'] != Auth::getUserId()
                ) {

                    $this->content['msg'] .= Msg::getMsg_('warning', 'TICKET_OTHER_RESPONSIBLE');
                    /**
                     * We display a ticket
                     */
                    $this->content['content'] = Func::getI()->viewTicket();
                    #
                } else {
                    /**
                     * We display a ticket
                     */
                    $this->content['content'] = Func::getI()->viewTicket();
                }
            }
            /**
             * Otherwise, if
             */
            else {
                $this->content = (new \App\Main\NoAccess\Cont)->getContent();
            }
        }
        /**
         * If a thicket with such ID does not exist
         */
        else {
            $this->content = (new \App\Main\Page404\Cont)->getContent();
        }

        return $this->content;
    }
}
