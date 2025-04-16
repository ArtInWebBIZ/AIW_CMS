<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\SearchBotsIp\Edit;

defined('AIW_CMS') or die;

use App\SearchBotsIp\Edit\Req\Func;
use Core\{Content, GV, Router, Session};
use Core\Plugins\{Msg, Ssl};
use Core\Plugins\Check\{CheckToken, EditNote, IntPageAlias};
use Core\Plugins\Save\ToLog;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = '#:TODO';

        if (Func::getI()->checkAccess() === true) {
            /**
             * Check edit note
             */
            if (EditNote::getI()->checkNote() === true) {
                /**
                 * Check global variable $_POST
                 */
                if (GV::post() === null) {
                    /**
                     * View edit form
                     */
                    $this->content['content'] .= Func::getI()->viewForm();
                    #
                }
                /**
                 * If $_POST variable is NOT empty
                 */
                else {
                    /**
                     * Check form token
                     */
                    if (CheckToken::checkToken() === true) {
                        /**
                         * Check form fields
                         */
                        if (!isset(Func::getI()->checkForm()['msg'])) {
                            /**
                             * Get only edited fields
                             */
                            if (Func::getI()->checkEditedFields() !== []) {
                                /**
                                 * Save data to content type table
                                 */
                                if (Func::getI()->saveToDb() !== false) {
                                    /**
                                     * Save to edit log content type table
                                     */
                                    if (Func::getI()->saveToEditLog() !== false) {
                                        /**
                                         * Redirect to view content type page
                                         */
                                        $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . IntPageAlias::check() . '.html';
                                    }
                                    /**
                                     * If error save to edit log
                                     */
                                    else {
                                        $this->errorToForm(Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR'));
                                    }
                                }
                                /**
                                 * If error save new values
                                 */
                                else {
                                    $this->errorToForm(Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR'));
                                }
                                #
                            } else {
                                /**
                                 * Redirect to view content type page
                                 */
                                $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . IntPageAlias::check() . '.html';
                            }
                            #
                        } else {
                            $this->errorToForm(Func::getI()->checkForm()['msg']);
                        }
                    }
                }
            }
            /**
             * If this content edited another user
             */
            else {
                /**
                 * View message
                 */
                $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_EDIT_NOTE_ERROR');
                /**
                 * Redirect to this content page
                 */
                $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . Router::getPageAlias() . '.html';
            }
            #
        } else {
            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }

    private function errorToForm(string $msg)
    {
        /**
         * View error message
         */
        $this->content['msg'] .= $msg;
        /**
         * Return to edit form
         */
        $this->content['content'] .= Func::getI()->viewForm();
        /**
         * Save message about error to log
         */
        ToLog::blockCounter(__FILE__ . ' - ' . __LINE__);
        /**
         * Update errors count in user`s session
         */
        Session::updSession(['block_counter' > Session::getSession()['block_counter'] + 1]);
    }
}
