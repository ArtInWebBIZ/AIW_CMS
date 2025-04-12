<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Add\Req;

defined('AIW_CMS') or die;

use App\User\Add\Req\Func;
use Core\{Config, Content, Session};
use Core\Plugins\{Msg, Ssl, Check\CheckToken};
use Core\Plugins\Dll\User\{Check, NewUser};
use Core\Plugins\Save\ToLog;

class Post
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'USER_ADD';
        /**
         * Compare token from form and this session token
         */
        if (CheckToken::checkToken() === true) {
            /**
             * Check data from form
             * If none errors in form values
             */
            if (!isset(Func::getI()->checkForm()['msg'])) {

                if (Func::getI()->checkUserIp() !== []) {
                    /**
                     * View message about ban add new user from this ip
                     */
                    $this->content['msg'] .= Msg::getMsgSprintf(
                        'warning',
                        'USER_BAN_ADD_NEW_USER_FROM_THIS_IP',
                        ...[(Config::getCfg('CFG_USER_ACTIVATION_TIME') / 60 / 60)]
                    );
                    /**
                     * Redirect to login page
                     */
                    $this->content['redirect'] = Ssl::getLinkLang() . 'user/login/';
                    #
                }
                /**
                 * If exist user in this email address
                 */
                elseif (Check::getI()->checkUserEmail(Func::getI()->checkForm()['email']) !== 0) {
                    /**
                     * View message that user in this email is exist
                     */
                    $this->content['msg'] .= Msg::getMsg_('warning', 'USER_EMAIL_ALREADY_EXISTS');
                    /**
                     * …and add other error this action
                     */
                    $this->errorAct();
                    #
                }
                /**
                 * If isset "phone" in form value
                 */
                elseif (isset(Func::getI()->checkForm()['phone'])) {
                    /**
                     * Check new user`s phone
                     */
                    if (Check::getI()->checkUserPhone(Func::getI()->checkForm()['phone']) === 0) {
                        /**
                         * Create new user
                         */
                        $userId = NewUser::getI()->create(
                            [
                                'email' => Func::getI()->checkForm()['email'],
                                'phone' => Func::getI()->checkForm()['phone'],
                            ]
                        );

                        if ($userId !== false) {
                            $this->successAct();
                        } else {
                            $this->errorAct();
                        }
                        #
                    }
                    /**
                     * Else, view message, that user in this phone is exist
                     */
                    else {
                        /**
                         * View message about this problem
                         */
                        $this->content['msg'] .= Msg::getMsg_('warning', 'USER_PHONE_ALREADY_EXISTS');
                        /**
                         * …and add other error this action
                         */
                        $this->errorAct();
                        #
                    }
                }
                /**
                 * If all values in form is correct
                 */
                else {
                    /**
                     * Create new user
                     */
                    $userId = NewUser::getI()->create(
                        [
                            'name'  => Func::getI()->checkForm()['name'],
                            'email' => Func::getI()->checkForm()['email'],
                        ]
                    );

                    if ($userId !== false) {
                        $this->successAct();
                    } else {
                        $this->errorAct();
                    }
                    #
                }
            }
            /**
             * Or view all errors message
             */
            else {
                /**
                 * View errors message
                 */
                $this->content['msg'] .= Func::getI()->checkForm()['msg'];
                /**
                 * …and add other error this action
                 */
                $this->errorAct();
                #
            }
        }

        return $this->content;
    }

    private function successAct()
    {
        /**
         * View message about success user`s register
         */
        $this->content['msg'] .= Msg::getMsg_('success', 'USER_REGISTER_SUCCESS');
        /**
         * Redirect user to login page
         */
        $this->content['redirect'] = Ssl::getLinkLang() . 'user/login/';
    }

    private function errorAct()
    {
        /**
         * View message about incorrect created new user
         */
        $this->content['msg'] .= Msg::getMsg_('warning', 'USER_NO_CORRECT_ADD');
        /**
         * View form add new user
         */
        $this->content['content'] .= Func::getI()->viewForm();
        /**
         * Save message about error to log
         */
        ToLog::blockCounter(__FILE__ . ' - ' . __LINE__);
        /**
         * Update session block_counter value
         */
        Session::updSession(
            ['block_counter' => Session::getSession()['block_counter'] + 1]
        );
    }
}
