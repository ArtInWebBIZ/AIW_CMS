<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item;

defined('AIW_CMS') or die;

use Core\{GV, Router, Session};
use Core\Plugins\Check\CheckToken;
use Core\Plugins\Item\Add\Func;
use Core\Plugins\Save\ToLog;
use Core\Plugins\Ssl;

class Add
{
    private $content = [];

    public function getContent()
    {
        if (Func::getI()->checkAccess() === true) {
            /**
             * Get item page parameters value
             */
            $this->content = Func::getI()->itemParams();
            /**
             * Check global variable $_POST
             */
            if (GV::post() === null) {
                /**
                 * View items add form
                 */
                $this->content['content'] .= Func::getI()->viewForm();
                #
            } else {
                /**
                 * Check token
                 */
                if (CheckToken::checkToken() === true) {
                    /**
                     * Check form values
                     */
                    if (!isset(Func::getI()->checkForm()['msg'])) {
                        /**
                         * Save form values to DB
                         */
                        if (!isset(Func::getI()->saveItem()['msg'])) {
                            /**
                             * Redirect to items view page
                             */
                            $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . Func::getI()->saveItem() . '.html';
                        } else {
                            /**
                             * View error message
                             */
                            $this->content['msg'] .= Func::getI()->saveItem()['msg'];
                            /**
                             * Save message about error to log
                             */
                            ToLog::blockCounter(__FILE__ . ' - ' . __LINE__);
                            /**
                             * Update error count in session
                             */
                            Session::updSession(['block_counter' => Session::getSession()['block_counter'] + 1]);
                            /**
                             * Redirect to items edit form
                             */
                            $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/add/';
                        }
                        #
                    } else {
                        /**
                         * View error message
                         */
                        $this->content['msg'] .= Func::getI()->checkForm()['msg'];
                        /**
                         * View form
                         */
                        $this->content['content'] .= Func::getI()->viewForm();
                    }
                }
            }
            #
        } else {
            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
