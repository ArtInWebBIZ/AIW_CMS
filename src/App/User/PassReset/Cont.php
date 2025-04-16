<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\PassReset;

defined('AIW_CMS') or die;

use App\User\PassReset\Req\Func;
use Core\Plugins\Dll\User;
use Core\{Config, Content, GV, Plugins\Msg, Plugins\Ssl};
use Core\Plugins\Check\CheckToken;

class Cont
{
    private $content = [];

    public function getContent()
    {
        User::getI()->deleteNotActivatedUsers();

        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'USER_NEW_PASSWORD';

        /**
         * Check user access
         */
        if (Func::getI()->getAccess() === true) {
            /**
             * We delete expired records in the pass_reset_note table
             */
            Func::getI()->delOldPassResetNote();
            /**
             * If these forms have not yet been sent
             */
            if (GV::post() === null && GV::get() === null) {
                /**
                 * We display the form of sending a new password
                 */
                $this->content['content'] = Func::getI()->getView();
            }
            /**
             * Otherwise, we process the received $_POST data
             */
            elseif (GV::post() !== null && GV::get() === null) {
                /**
                 * Check token
                 */
                if (CheckToken::checkToken() === true) {
                    /**
                     * We check the compliance of the received data type email
                     */
                    if (!isset(Func::getI()->checkForm()['msg'])) {
                        /**
                         * Check if there is a user with such an address email
                         *
                         * If a user with such an email has
                         */
                        if (Func::getI()->checkUserEmail() !== 0) {
                            /**
                             * We check if there is a record about the new password
                             * For this user
                             * If there is no record
                             */
                            if (Func::getI()->getPassResetNote() === 0) {
                                /**
                                 * We enter the data on the change of password to the table pass_reset_note
                                 */
                                Func::getI()->saveToPassResetNote();

                                /** 
                                 * We enter the data on the change of password to the table 
                                 */
                                Func::getI()->sendEmail();

                                /**
                                 * We display a message about the successful sending of the password to the specified email
                                 */
                                $this->content['msg'] .= Msg::getMsgSprintf(
                                    'success',
                                    'USER_SEND_RESET_PASSWORD_SUCCESS',
                                    ...[Config::getCfg('CFG_MIN_SESSION_TIME') / 60]
                                );

                                $this->content['redirect'] = Ssl::getLinkLang();
                            }
                            /**
                             * If there is a record
                             */
                            else {
                                /**
                                 * We display a message that the next attempt to change password
                                 * will be available through ?? minutes
                                 */
                                $this->content['msg'] .= Msg::getMsgSprintf(
                                    'warning',
                                    'USER_NEW_RESET_PASSWORD_SESSION',
                                    ...[Config::getCfg('CFG_MIN_SESSION_TIME') / 60,]
                                );

                                $this->content['redirect'] = Ssl::getLinkLang();
                            }
                        }
                        /**
                         * If there is no user with such an email,
                         * We display a message about the successful sending of the password to the specified email
                         */
                        else {

                            $this->content['msg'] .= Msg::getMsgSprintf('success', 'USER_SEND_RESET_PASSWORD_SUCCESS', ...[
                                Config::getCfg('CFG_MIN_SESSION_TIME') / 60,
                            ]);

                            $this->content['redirect'] = Ssl::getLinkLang();
                        }
                    }
                    /**
                     * Otherwise, send a message about the wrong format
                     * entered email address
                     * and display the form of obtaining a new password again
                     */
                    else {
                        $this->content['msg'] .= Msg::getMsg_('warning', 'USER_EMAIL_NO_CORRECT');
                        $this->content['content'] = Func::getI()->getView();
                    }
                }
            }
            /**
             * If the user has crossed the link in the letter
             */
            elseif (GV::post() === null && GV::get() !== null) {
                /**
                 * We check the correctness of the activation code of the new password
                 */
                if (Func::getI()->checkCode() !== false) {
                    /**
                     * We check if there is such a code in the database pass_reset_note
                     * If such a code exists
                     */
                    if (Func::getI()->getPassResetNoteFromCode() !== false) {
                        /**
                         * We delete the record with this activation code from the database
                         */
                        $userId = (int) Func::getI()->getPassResetNoteFromCode()['user_id'];
                        Func::getI()->delPassResetNote($userId);
                        /**
                         * We change the password in the user profile
                         * and increase by 1 meter of changes in the user profile
                         */
                        Func::getI()->updateUserProfile(
                            $userId,
                            [
                                'password' => Func::getI()->getPassResetNoteFromCode()['new_password'],
                                'edited'   => time(),
                            ]
                        );
                        /**
                         * We make an entry into the log of the user profile changes
                         */
                        Func::getI()->saveToUserEditLog([
                            'edited_id'    => $userId,
                            'editor_id'    => $userId,
                            'edited_field' => 'password',
                            'old_value'    => '***** old password *****',
                            'new_value'    => '***** new password *****',
                            'edited'       => time(),
                        ]);
                        /**
                         * We display a message about the successful change of user password
                         */
                        $this->content['msg'] .= Msg::getMsg_('success', 'USER_RESET_PASSWORD_SUCCESS');
                        $this->content['redirect'] = Ssl::getLinkLang();
                    }
                    /**
                     * If there is no such code
                     * We display a message that such an activation code does not exist
                     * and display the form of sending a new password
                     */
                    else {

                        $this->content['msg'] .= Msg::getMsg_('warning', 'USER_NO_CORRECT_RESET_CODE');
                        $this->content['redirect'] = Ssl::getLinkLang();
                    }
                }
                /**
                 * If the code is not correct
                 * We display a message about an incorrect code
                 * Activation of the new user password
                 */
                else {

                    $this->content['msg'] .= Msg::getMsg_('warning', 'USER_NO_CORRECT_RESET_CODE');
                    $this->content['redirect'] = Ssl::getLinkLang();
                }
            }
        }
        /**
         * Otherwise, we display a message about the prohibition of access
         */
        else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
