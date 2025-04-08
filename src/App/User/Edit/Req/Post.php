<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\Edit\Req;

defined('AIW_CMS') or die;

use App\User\Edit\Req\Func;
use Core\{Auth, Config, Content, GV, Session, Trl};
use Core\Plugins\{Msg, Ssl, Dll\User, Check\EditNote, Check\CheckToken};
use Core\Plugins\Check\IntPageAlias;

class Post
{
    private $content = '';

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'USER_EDIT';
        /**
         * Check token
         */
        if (CheckToken::checkToken() === true) {
            /**
             * Check form data
             */
            if (!isset(Func::getI()->checkFormValues()['msg'])) {
                /**
                 * Compare with the user profile and additionally check
                 * avatar correctness
                 */
                if (!isset(Func::getI()->compareUserProfile()['msg'])) {
                    /**
                     * If no user profile values have changed
                     */
                    if (Func::getI()->compareUserProfile() === null) {
                        /**
                         * Delete an edit entry
                         */
                        EditNote::getI()->deleteNote();

                        $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . IntPageAlias::check() . '.html';
                    }
                    /**
                     * If in users profile is edited fields
                     */
                    else {
                        /**
                         * If edited email
                         */
                        if (isset(Func::getI()->compareUserProfile()['email'])) {
                            /**
                             * If correct new users email
                             */
                            if (Func::getI()->checkNewUserEmail() === null) {
                                $this->ifEditUsersEmailOrPhone();
                            }
                            /**
                             * If incorrect new users email
                             */
                            else {
                                /**
                                 * View error message
                                 */
                                $this->content['msg'] .= Msg::getMsg_('warning', 'USER_EMAIL_ALREADY_EXISTS');
                                /**
                                 * Redirect to users profile page
                                 */
                                $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . IntPageAlias::check() . '.html';
                            }
                        }
                        /**
                         * If changed users phone
                         */
                        if (isset(Func::getI()->compareUserProfile()['phone'])) {
                            /**
                             * If correct new users phone
                             */
                            if (Func::getI()->checkNewUserPhone() === null) {
                                $this->ifEditUsersEmailOrPhone();
                            } else {
                                /**
                                 * View error message
                                 */
                                $this->content['msg'] .= Msg::getMsg_('warning', 'USER_PHONE_ALREADY_EXISTS');
                                /**
                                 * Redirect to users profile page
                                 */
                                $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . IntPageAlias::check() . '.html';
                            }
                        }
                        /**
                         * If all changed values is correct
                         */
                        $this->saveCorrectValues();
                    }
                } else {
                    /**
                     * View error message
                     */
                    $this->content['msg'] .= Func::getI()->compareUserProfile()['msg'];
                    /**
                     * Redirect to user edit page
                     */
                    $this->content['redirect'] = Ssl::getLinkLang() . 'user/edit/' . IntPageAlias::check() . '.html';
                }
            } else {

                $this->content['msg'] .= Func::getI()->checkFormValues()['msg'];

                $this->content['redirect'] = Ssl::getLinkLang() . 'user/edit/' . IntPageAlias::check() . '.html';
            }
        }

        return $this->content;
    }

    private function saveCorrectValues(): void
    {
        /**
         * Making changes to the user profile
         */
        Func::getI()->updateEditedUserProfile();
        /**
         * Logging a change message
         */
        if (Func::getI()->saveUserEditToLog() === false) {
            $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_ERROR_SAVE_TO_USER_EDIT_LOG');
        }
        /**
         * Delete an edit entry
         */
        EditNote::getI()->deleteNote();
        /**
         * Redirect to,user page
         */
        $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . IntPageAlias::check() . '.html';
    }

    private function ifEditUsersEmailOrPhone()
    {
        /**
         * Save new activation code to database
         */
        User::getI()->saveToActivationTable(Func::getI()->getCustomUser()['id']);
        /**
         * Send activation letter to users email
         */
        if (isset(Func::getI()->compareUserProfile()['email'])) {
            $confirm = 'EMAIL_CONFIRM_NEW_EMAIL';
        }

        if (isset(Func::getI()->compareUserProfile()['phone'])) {
            $confirm = 'EMAIL_CONFIRM_NEW_PHONE';
        }

        (new \Core\Modules\Email)->sendEmail(
            Func::getI()->checkFormValues()['email'],
            Trl::_('USER_ACTIVATION'),
            Trl::sprintf(
                $confirm,
                ...[
                    Ssl::getLinkLang() . 'user/login/',
                    Ssl::getLinkLang() . 'user/login/',
                    Ssl::getLinkLang() . 'contacts/',
                ]
            )
        );
        /**
         * Update sessions parameters
         */
        if (IntPageAlias::check() == Auth::getUserId()) {

            Session::updSession([
                'user_id'    => 0,
                'tmp_status' => -1,
                'views'      => 0,
            ]);

            $this->content['msg'] .= Msg::getMsg_('warning', 'USER_EDITED_EMAIL_OR_PHONE_DATA');
        }
        /**
         * Redirect to home page
         */
        $this->content['redirect'] = Ssl::getLinkLang();
    }
}
