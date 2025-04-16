<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Ticket\NewTicket;

defined('AIW_CMS') or die;

use App\Ticket\NewTicket\Req\Func;
use Core\{Config, GV, Content, Trl};
use Core\Plugins\{Msg, Ssl};

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content = Content::getDefaultValue();

        if (Func::getI()->checkAccess() === true) {

            if (GV::post() === null) {
                /**
                 * Redirect in contacts page
                 */
                $this->content['redirect'] = Ssl::getLinkLang() . 'contacts/';
            }
            /**
             * If POST not empty
             */
            else {
                /**
                 * Check form values
                 */
                if (!isset(Func::getI()->checkForm()['msg'])) {
                    /**
                     * Save new ticket to DB
                     */
                    if (Func::getI()->saveNewTicket() > 0) {
                        /**
                         * If ticket type is delete user
                         */
                        if (
                            Func::getI()->checkForm()['ticket_type'] == 6
                        ) {
                            /**
                             * Save confirm code to database
                             */
                            Func::getI()->saveConfirmCode();
                            /**
                             * Send email to creators user
                             */
                            Func::getI()->sendEmail(6);
                            /**
                             * Send email to manager
                             */
                            Func::getI()->sendToManagerEmail(Config::getCfg('CFG_TECH_SUPPORT_USER_EMAIL'));
                            #
                        } elseif (Func::getI()->checkForm()['ticket_type'] == 3) {
                            Func::getI()->sendToManagerEmail(Config::getCfg('CFG_REPLY_TO'));
                        } else {
                            Func::getI()->sendToManagerEmail(Config::getCfg('CFG_TECH_SUPPORT_USER_EMAIL'));
                        }
                        /**
                         * Redirect to new tickets page
                         */
                        $this->content['redirect'] = Ssl::getLinkLang() . 'ticket/' . Func::getI()->saveNewTicket() . '.html';
                    }
                    /**
                     * If new tickets not saved
                     */
                    else {
                        /**
                         * View error message
                         */
                        $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR');
                        /**
                         * Redirect to contacts page
                         */
                        $this->content['redirect'] = Ssl::getLinkLang() . 'contacts/';
                    }
                    #
                } else {
                    /**
                     * View error message
                     */
                    $this->content['msg'] .= Func::getI()->checkForm()['msg'];
                    /**
                     * Redirect to contacts page
                     */
                    $this->content['redirect'] = Ssl::getLinkLang() . 'contacts/';
                }
            }
            #
        } else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
            #
        }

        return $this->content;
    }
}
