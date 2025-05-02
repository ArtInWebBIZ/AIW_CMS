<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\ChangePass;

defined('AIW_CMS') or die;

use App\User\ChangePass\Req\Func;
use Comp\User\Lib\User;
use Core\{Auth, Config, Content, GV};
use Core\Plugins\{Check\CheckToken, Msg, Ssl};

class Cont
{

    private $content = [];

    public function getContent()
    {
        if (Func::getI()->checkAccess() === true) {

            $this->content          = Content::getDefaultValue();
            $this->content['title'] = 'USER_CHANGE_PASSWORD';

            User::getI()->deleteNotActivatedUsers();

            if (GV::post() === null) {
                /**
                 * We display the form
                 */
                $this->content['content'] = Func::getI()->getChangePassForm();
            }
            /**
             * If the data from the form is obtained
             */
            else {
                /**
                 * Check the form of the form and token session
                 */
                if (CheckToken::checkToken() === true) {
                    /**
                     * Check the correctness of the entered old password
                     */
                    if (Func::getI()->checkOldPassword() === false) {
                        /**
                         * Send a message about the wrong old password
                         */
                        $this->content['msg'] .= Msg::getMsg_('warning', 'CONFIRM_NO_CONFIRM_OLD_PASSWORD');
                    }
                    /**
                     * We check the correctness of the new password entered
                     */
                    if (Func::getI()->checkNewPassword() === false) {
                        $this->content['msg'] .= Msg::getMsgSprintf(
                            'warning',
                            'CONFIRM_NO_LEN_NEW_PASSWORD',
                            ...[
                                Config::getCfg('CFG_MIN_PASS_LEN'),
                                Config::getCfg('CFG_MAX_PASS_LEN'),
                            ]
                        );
                    }
                    /**
                     * We check the confirmation of the new password
                     */
                    if (Func::getI()->checkConfirmNewPassword() === false) {
                        $this->content['msg'] .= Msg::getMsg_('warning', 'CONFIRM_NO_CONFIRM_NEW_PASSWORD');
                    }
                    /**
                     * If there are any warnings,
                     * We display the editing form
                     */
                    if ($this->content['msg'] != '') {
                        $this->content['content'] = Func::getI()->getChangePassForm();
                    }
                    /**
                     * Otherwise, we process the data received
                     */
                    else {
                        /**
                         * If the password has not changed
                         */
                        if (Func::getI()->oldPassHash() === Func::getI()->checkNewPassword()) {
                            /**
                             * We redirect the user to the profile page
                             */
                            $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . Auth::getUserId() . '.html';
                            #
                        } else {
                            /**
                             * Record the new password in the database
                             * If the password has successfully signed up
                             */
                            if (Func::getI()->saveNewPassword()) {
                                /**
                                 * Record the change in the user profile in the log
                                 */
                                Func::getI()->saveChangeToLog();
                                /**
                                 * We redirect the user to the profile page
                                 */
                                $this->content['msg'] .= Msg::getMsg_('success', 'USER_CHANGE_PASSWORD_SUCCESS');
                                $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . Auth::getUserId() . '.html';
                                #
                            }
                            /**
                             * If errors occur when recording
                             * Return to the page page
                             */
                            else {

                                $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_SAVE_CHANGE_ERROR');
                                $this->content['redirect'] = Ssl::getLinkLang() . 'user/change-pass/' . Auth::getUserId() . '.html';
                                #
                            }
                        }
                    }
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
