<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\NewUser\Req;

defined('AIW_CMS') or die;

use App\User\NewUser\Req\Func;
use Core\Content;
use Core\Plugins\{Msg, Ssl, Check\CheckToken};

class Post
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'USER_ADD';
        /**
         * Проверяем, токен из формы и токен сессии
         */
        if (CheckToken::checkToken() === true) {
            /**
             * Проверяем данные из формы
             * Если никаких ошибок и сообщений нет
             */
            if (!isset(Func::getI()->checkDataFromPost()['msg'])) {
                /**
                 * Проверяем, есть ли пользователь с таким адресом email
                 */
                if (
                    Func::getI()->checkNewUserEmail() === 0 &&
                    Func::getI()->checkNewUserPhone() === 0
                ) {
                    /**
                     * Добавляем профиль пользователя в БД
                     * Если новый пользователь корректно добавлен
                     */
                    if (Func::getI()->addUser() !== 0) {
                        /**
                         * Перенаправляем на страницу пользователя
                         */
                        $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . Func::getI()->addUser() . '.html';
                    }
                    /**
                     * Иначе, выводим сообщение, что регистрация нового пользователя
                     * прошла не удачно, просьба заполнить форму регистрации ещё раз
                     */
                    else {
                        $this->content['msg'] .= Msg::getMsg_('warning', 'USER_NO_CORRECT_ADD');
                        $this->content['content'] .= Func::getI()->getAddUserForm();
                    }
                    #
                } elseif (Func::getI()->checkNewUserEmail() !== 0) {
                    /**
                     * View message that user in this email is exist
                     */
                    $this->content['msg'] .= Msg::getMsg_('warning', 'USER_EMAIL_ALREADY_EXISTS');
                    /**
                     * Redirect to login page
                     */
                    $this->content['redirect'] = Ssl::getLinkLang() . 'user/login/';
                    #
                } else {
                    /**
                     * Else, view message, that user in this phone is exist
                     */
                    $this->content['msg'] .= Msg::getMsg_('warning', 'USER_PHONE_ALREADY_EXISTS');
                    /**
                     * Redirect to login page
                     */
                    $this->content['redirect'] = Ssl::getLinkLang() . 'user/login/';
                }
            }
            /**
             * Иначе, выводим все сообщения…
             */
            else {
                $this->content['msg'] .= Func::getI()->checkDataFromPost()['msg'];
                /**
                 * …и форму регистрации нового пользователя
                 */
                $this->content['content'] .= Func::getI()->getAddUserForm();
            }
        }

        return $this->content;
    }
}
