<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
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
         * Проверяем доступ пользователя
         */
        if (Func::getI()->getAccess() === true) {
            /**
             * Удаляем просроченные записи в таблице pass_reset_note
             */
            Func::getI()->delOldPassResetNote();
            /**
             * Если данные формы ещё не отправлены
             */
            if (GV::post() === null && GV::get() === null) {
                /**
                 * Выводим форму отправки нового пароля
                 */
                $this->content['content'] = Func::getI()->getView();
            }
            /**
             * Иначе, обрабатываем полученные $_POST данные
             */
            elseif (GV::post() !== null && GV::get() === null) {
                /**
                 * Check token
                 */
                if (CheckToken::checkToken() === true) {
                    /**
                     * Проверяем соответствие полученных данных
                     * типу email
                     */
                    if (!isset(Func::getI()->checkForm()['msg'])) {
                        /**
                         * Проверяем, есть ли пользователь с таким адресом email
                         *
                         * Если пользователь с таким email есть
                         */
                        if (Func::getI()->checkUserEmail() !== 0) {
                            /**
                             * Проверяем, есть ли запись о новом пароле
                             * для этого пользователя
                             * Если записи нет
                             */
                            if (Func::getI()->getPassResetNote() === null) {
                                /**
                                 * Вносим данные о смене пароля в таблицу pass_reset_note
                                 */
                                Func::getI()->saveToPassResetNote();

                                /** ВЫСЫЛАЕМ ПИСЬМО С НОВЫМ ПАРОЛЕМ НА УКАЗАННЫЙ EMAIL */
                                Func::getI()->sendEmail();

                                /**
                                 * Выводим сообщение об успешной отправке пароля на указанный email
                                 */
                                $this->content['msg'] .= Msg::getMsgSprintf(
                                    'success',
                                    'USER_SEND_RESET_PASSWORD_SUCCESS',
                                    ...[Config::getCfg('CFG_MIN_SESSION_TIME') / 60]
                                );

                                $this->content['redirect'] = Ssl::getLinkLang();
                            }
                            /**
                             * Если запись есть
                             */
                            else {
                                /**
                                 * Выводим сообщение, что следующая попытка смены пароля
                                 * будет доступна через ?? минут
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
                         * Если пользователя с таким email нет,
                         * выводим сообщение об успешной отправке пароля на указанный email
                         */
                        else {

                            $this->content['msg'] .= Msg::getMsgSprintf('success', 'USER_SEND_RESET_PASSWORD_SUCCESS', ...[
                                Config::getCfg('CFG_MIN_SESSION_TIME') / 60,
                            ]);

                            $this->content['redirect'] = Ssl::getLinkLang();
                        }
                    }
                    /**
                     * Иначе, отправляем сообщение о неверном формате
                     * введенного адреса электронной почты
                     * и выводим снова форму получения нового пароля
                     */
                    else {
                        $this->content['msg'] .= Msg::getMsg_('warning', 'USER_EMAIL_NO_CORRECT');
                        $this->content['content'] = Func::getI()->getView();
                    }
                }
            }
            /**
             * Если пользователь перешёл по ссылке в письме
             */
            elseif (GV::post() === null && GV::get() !== null) {
                /**
                 * Проверяем корректность кода активации нового пароля
                 */
                if (Func::getI()->checkCode() !== false) {
                    /**
                     * Проверяем, есть ли такой код в БД pass_reset_note
                     * Если такой код существует
                     */
                    if (Func::getI()->getPassResetNoteFromCode() !== false) {
                        /**
                         * Удаляем запись с этим кодом активации из БД
                         */
                        $userId = (int) Func::getI()->getPassResetNoteFromCode()['user_id'];
                        Func::getI()->delPassResetNote($userId);
                        /**
                         * Изменяем пароль в профиле пользователя
                         * и увеличиваем на 1 счётчик изменений в профиле пользователя
                         */
                        Func::getI()->updateUserProfile(
                            $userId,
                            [
                                'password' => Func::getI()->getPassResetNoteFromCode()['new_password'],
                                'edited'   => time(),
                            ]
                        );
                        /**
                         * Вносим запись в лог изменений профиля пользователя
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
                         * Выводим сообщение, об успешной смене пароля пользователя
                         */
                        $this->content['msg'] .= Msg::getMsg_('success', 'USER_RESET_PASSWORD_SUCCESS');
                        $this->content['redirect'] = Ssl::getLinkLang();
                    }
                    /**
                     * Если такого кода нет
                     * выводим сообщение, что такого кода активации не существует
                     * и выводим форму отправки нового пароля
                     */
                    else {

                        $this->content['msg'] .= Msg::getMsg_('warning', 'USER_NO_CORRECT_RESET_CODE');
                        $this->content['redirect'] = Ssl::getLinkLang();
                    }
                }
                /**
                 * Если код не корректный
                 * выводим сообщение о некорректном коде
                 * активации нового пароля пользователя
                 */
                else {

                    $this->content['msg'] .= Msg::getMsg_('warning', 'USER_NO_CORRECT_RESET_CODE');
                    $this->content['redirect'] = Ssl::getLinkLang();
                }
            }
        }
        /**
         * Иначе, выводим сообщение о запрещении доступа
         */
        else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
