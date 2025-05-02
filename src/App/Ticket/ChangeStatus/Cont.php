<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Ticket\ChangeStatus;

defined('AIW_CMS') or die;

use App\Ticket\ChangeStatus\Req\Func;
use Core\Plugins\{Msg, Ssl};
use Core\{Trl, GV, Content};

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content = Content::getDefaultValue();

        if (GV::post() === null) {
            $this->content['redirect'] = Ssl::getLinkLang();
        } else {
            /**
             * We check the rights of access
             */
            if (Func::getI()->checkAccess()) {
                /**
                 * We check for the correctness data from the form
                 */
                if (!isset(Func::getI()->formCheck()['msg'])) {
                    /**
                     * We change the status of a ticket
                     */
                    if (Func::getI()->changeTicketStatus()) {
                        /**
                         * Record data on changes in the log
                         */
                        Func::getI()->saveChangeTicketStatusToLog();

                        $this->content['redirect'] = isset(GV::server()['HTTP_REFERER']) ?
                            GV::server()['HTTP_REFERER'] :
                            Ssl::getLinkLang() . 'ticket/control/';

                        $this->content['msg'] .= Msg::getMsg_('success', Trl::_('TICKET_STATUS_CHANGE_SUCCESS'));
                    }
                    /**
                     * If something went wrong
                     */
                    else {

                        $this->content['redirect'] = GV::server()['HTTP_REFERER'];

                        $this->content['msg'] .= Msg::getMsg_('warning', Trl::_('TICKET_STATUS_NO_CHANGE'));
                    }
                }
                /**
                 * If the data from the form is not correct
                 */
                else {

                    $this->content['msg'] .= Func::getI()->formCheck()['msg'];

                    $this->content['redirect'] = GV::server()['HTTP_REFERER'];
                }
            }
            /**
             * If the user does not have access rights
             */
            else {
                $this->content = (new \App\Main\NoAccess\Cont)->getContent();
            }
        }

        return $this->content;
    }
}
