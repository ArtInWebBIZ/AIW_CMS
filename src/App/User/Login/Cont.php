<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Login;

defined('AIW_CMS') or die;

use App\User\Login\Req\Func;
use Comp\User\Lib\User;
use Core\{Auth, Config, Content, GV, Session, Languages};
use Core\Plugins\{Ssl, Msg, Check\CheckToken};

class Cont
{
    private $content   = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'USER_LOGIN';

        User::getI()->deleteNotActivatedUsers();

        if (GV::post() === null) {

            if (Auth::getUserId() === 0) {
                $this->content['content'] .= Func::getI()->viewLoginForm();
            } else {
                $this->content['redirect'] = Ssl::getLinkLang();
            }
            #
        } else {
            /**
             * Check session token
             */
            if (CheckToken::checkToken() === true) {
                /**
                 * If isset or not HTTP_REFERER
                 */
                $redirect = Func::getI()->referer();
                /**
                 * If isset this user
                 */
                if (is_array(Func::getI()->getUser())) {
                    /**
                     * If password is correct
                     */
                    if (Func::getI()->checkUserPassword()) {
                        /**
                         * Delete other users session
                         */
                        Func::getI()->deleteOtherUsersSession();
                        /**
                         * If users status not activated
                         */
                        if (Func::getI()->getUser()['status'] == 0) {
                            /**
                             * Update session
                             */
                            $this->updateSessionToActiveUser();
                            /**
                             * Update users parameters
                             */
                            User::getI()->updateUserStatus(Func::getI()->getUser()['id']);
                            /**
                             * Save new user parameters to log
                             */
                            User::getI()->saveToEditLog(
                                [
                                    'edited_id'    => Func::getI()->getUser()['id'],
                                    'editor_id'    => Func::getI()->getUser()['id'],
                                    'edited_field' => 'status',
                                    'old_value'    => 0,
                                    'new_value'    => 1,
                                    'edited'       => time(),
                                ]
                            );
                            /**
                             * Delete record in activation table
                             */
                            Func::getI()->deleteRecordInActivationTable();
                            /**
                             * View message to activates new user
                             */
                            $this->content['msg'] .= Msg::getMsg_('success', 'USER_CORRECT_ACTIVATION');
                            /**
                             * Redirect to home page
                             */
                            $this->content['redirect'] = Ssl::getLinkLang();
                            #
                        }
                        /**
                         * Redirect to users page
                         */
                        elseif (str_contains($redirect, "/login/")) {
                            /**
                             * Update session
                             */
                            $this->updateSessionToActiveUser();
                            /**
                             * Redirect to users page
                             */
                            $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . Func::getI()->getUser()['id'] . '.html';
                            #
                        } else {
                            /**
                             * Update session
                             */
                            $this->updateSessionToActiveUser();

                            $this->content['redirect'] = $redirect;
                            #
                        }
                        /**
                         * Send email to user about login
                         */
                        Func::getI()->sendEmailAboutLogin();
                    }
                    /**
                     * If user password is incorrect
                     */
                    else {
                        /**
                         * View incorrect message
                         */
                        $this->content['msg'] .= Func::getI()->noCorrectEmailOrPassword();

                        $this->content['redirect'] = $redirect;
                    }
                }
                /**
                 * If not isset this user
                 */
                else {
                    /**
                     * View errors message
                     */
                    $this->content['msg'] .= Func::getI()->noCorrectEmailOrPassword();
                    /**
                     * …and redirect to Home page
                     */
                    $this->content['redirect'] = Ssl::getLinkLang();
                    #
                }
            }
        }

        return $this->content;
    }
    /**
     * Update session parameters
     */
    private function updateSessionToActiveUser()
    {
        Session::updSession(
            [
                'user_id'      => Func::getI()->getUser()['id'],
                'tmp_status'   => Func::getI()->getUser()['status'] == 0 ? 1 : Func::getI()->getUser()['status'],
                'lang'         => count(Languages::langList()) > 1 ? Func::getI()->getUser()['lang'] : Languages::langList()[0][0],
                'save_session' => 1,
                'enabled_to'   => time() + Config::getCfg('CFG_MAX_SESSION_TIME'),
            ]
        );
    }
    #
}
