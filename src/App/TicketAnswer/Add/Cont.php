<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\TicketAnswer\Add;

use App\TicketAnswer\Add\Req\Func;
use Core\{Auth, Content, GV};
use Core\Plugins\{Msg, Ssl, Check\CheckToken};

defined('AIW_CMS') or die;

class Cont
{

    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'TICKET_ANSWER_ADD';

        if (GV::post() !== null) {

            if (Func::getI()->checkAccess() === true) {
                /**
                 * Check the token
                 */
                if (CheckToken::checkToken() === true) {
                    /**
                     * We check the data of the form
                     */
                    if (!isset(Func::getI()->checkPost()['msg'])) {
                        /**
                         * Add the answer to the database
                         */
                        if (Func::getI()->addAnswer() !== 0) {
                            /**
                             * We increase by 1 meter of answers to the thicket
                             */
                            Func::getI()->toEnlargeAnswerCount();
                            /**
                             * Send answers email
                             */
                            Func::getI()->sendAnswersEmail();
                            /**
                             * We redirect the ticket page
                             */
                            $this->content['redirect'] = Ssl::getLinkLang() . 'ticket/' . Func::getI()->checkTicket()['id'] . '.html';
                        } else {
                            $this->content['msg'] .= Msg::getMsg_('warning', 'TICKET_ADD_ERROR');
                            $this->content['redirect'] = Ssl::getLinkLang() . 'ticket/' . Func::getI()->checkTicket()['id'] . '.html';
                        }
                    }
                    /**
                     * If these forms are transmitted with errors
                     */
                    else {
                        $this->content['msg'] .= Func::getI()->checkPost()['msg'];
                        $this->content['redirect'] = Ssl::getLinkLang() . 'ticket/' . Func::getI()->checkTicket()['id'] . '.html';
                    }
                }
                #
            } else {

                if (
                    Func::getI()->checkTicket()['author_id'] == Auth::getUserId() ||
                    (Auth::getUserGroup() > 2 &&
                        Auth::getUserStatus() == 1
                    )
                ) {
                    $this->content['msg'] .= Msg::getMsg_('warning', 'TICKET_NO_ADD_ACCESS_MSG');
                    $this->content['redirect'] = Ssl::getLinkLang() . 'ticket/' . Func::getI()->checkTicket()['id'] . '.html';
                } else {
                    $this->content = (new \App\Main\NoAccess\Cont)->getContent();
                }
            }
            #
        } else {
            $this->content['redirect'] = Ssl::getLinkLang();
        }

        return $this->content;
    }
}
