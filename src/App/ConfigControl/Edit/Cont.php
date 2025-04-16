<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ConfigControl\Edit;

defined('AIW_CMS') or die;

use App\ConfigControl\Edit\Req\Func;
use Core\{Content, GV, Router};
use Core\Plugins\Check\{CheckToken, EditNote};
use Core\Plugins\{Msg, Ssl};

class Cont
{

    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['tpl']   = 'admin';
        $this->content['title'] = 'CONFIG_PARAMETER_EDIT';

        if (Func::getI()->checkAccess() === true) {
            /**
             * Check edit note
             */
            if (EditNote::getI()->checkNote() === true) {
                /**
                 * If from post not send values
                 */
                if (GV::post() === null) {
                    /**
                     * Check EditNote
                     */
                    /**
                     * View config edit form
                     */
                    $this->content['content'] = Func::getI()->viewEditForm();
                }
                /**
                 * If from post SEND values
                 */
                else {
                    /**
                     * Check forms token
                     */
                    if (CheckToken::checkToken() === true) {
                        /**
                         * If corrects form values
                         */
                        if (!isset(Func::getI()->checkForm()['msg'])) {
                            /**
                             * If isset edited fields
                             */
                            if (Func::getI()->countEditedFields() > 0) {
                                /**
                                 * If correct save edited values to DB
                                 */
                                if (Func::getI()->updateEditedValues() === true) {
                                    /**
                                     * Save edited action to log
                                     */
                                    Func::getI()->saveEditToLog();
                                    /**
                                     * Redirect to config control page
                                     */
                                    $this->content['redirect'] = Ssl::getLinkLang() . 'config-control/control/';
                                    /**
                                     * Delete EditNote
                                     */
                                    EditNote::getI()->deleteNote();
                                }
                                /**
                                 * If incorrect save edited values to DB
                                 */
                                else {
                                    /**
                                     * View error message
                                     */
                                    $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR');
                                    /**
                                     * View config edit form
                                     */
                                    $this->content['content'] .= Func::getI()->viewEditForm();
                                }
                            }
                            /**
                             * If not isset edited values
                             */
                            else {
                                /**
                                 * Redirect to control page
                                 */
                                $this->content['redirect'] = Ssl::getLinkLang() . 'config-control/control/';
                            }
                        }
                        /**
                         * If error form values
                         */
                        else {
                            /**
                             * View errors message
                             */
                            $this->content['msg'] .= Func::getI()->checkForm()['msg'];
                            /**
                             * View config edit form
                             */
                            $this->content['content'] .= Func::getI()->viewEditForm();
                        }
                    }
                }
                #
            } else {
                /**
                 * View message about error
                 */
                $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_EDIT_NOTE_ERROR');
                /**
                 * Redirect to config control page
                 */
                $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/';
                #
            }
            #
        } else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
