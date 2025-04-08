<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
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
         * Проверяем, существует ли тикет с таким ID
         */
        if (
            Func::getI()->getTicketId() > 0 &&
            Func::getI()->getTicket() !== false
        ) {
            /**
             * Проверяем допуск пользователя
             */
            if (Func::getI()->checkAccess() === true) {
                /**
                 * Если статус тикета "Ещё не рассматривался",
                 * и пользователь является модератором
                 * меняем статус тикета на "Рассматривается"
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
                     * Регистрируем изменения в логе изменений тикета
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
                     * Выводим тикет
                     */
                    $this->content['content'] = Func::getI()->viewTicket();
                    #
                } else {
                    /**
                     * Выводим тикет
                     */
                    $this->content['content'] = Func::getI()->viewTicket();
                }
            }
            /**
             * Иначе, если
             */
            else {
                $this->content = (new \App\Main\NoAccess\Cont)->getContent();
            }
        }
        /**
         * Если тикета с таким ID не существует
         */
        else {
            $this->content = (new \App\Main\Page404\Cont)->getContent();
        }

        return $this->content;
    }
}
