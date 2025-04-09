<?php

/**
 * @package    ArtInWebCMS.lang
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

/**
 * !!! Everything inside HTML tags is NOT TRANSLATED !!!
 */

$emailFooter = '<br><br><hr style="border:none; border-bottom:1px solid gold"><br><span style="display:block; font-size:x-small; text-align:center">Если при каких либо действиях на сайте ваш email был указан не вами, сообщите об этом администрации сайта на странице <a href="%s">Контакты</a></span>';

return [
    'EMAIL_CONFIRM'                  => 'Подтвердите свой адрес электронной почты',
    'EMAIL_CONFIRM_NEW_EMAIL'        => '<b>Здравствуйте</b>!<br><br>Чтобы подтвердить свой новый email, авторизуйтесь на сайте:<br><br><a href="%s">%s</a>' . $emailFooter,
    'EMAIL_CONFIRM_NEW_PHONE'        => '<b>Здравствуйте</b>!<br><br>Чтобы подтвердить свой новый номер телефона, авторизуйтесь на сайте:<br><br><a href="%s">%s</a>' . $emailFooter,
    'EMAIL_CREATE_NEW_USER'          => '<b>Здравствуйте</b>!<br><br>Чтобы активировать свой профиль, авторизуйтесь на сайте используя указанный ниже пароль.<br><br><a href="%s">%s</a><br><br>Ваш пароль для входа на сайт: <strong>%s</strong>' . $emailFooter,
    'EMAIL_SEND_NEW_PASSWORD'        => 'Ваш новый пароль: <b>%s</b><br><br>Чтобы активировать новый пароль в вашем профиле, пожалуйста перейдите по указанной ниже ссылке:<br><br><a href="%s">%s</a><br><br>Если вы не запрашивали новый пароль <strong>НЕ ПЕРЕХОДИТЕ ПО УКАЗАННОЙ ССЫЛКЕ</strong>! В этом случае останется действительным ваш старый пароль.' . $emailFooter,
    'EMAIL_NEW_TICKET_SUBJECT'       => 'Создан новый тикет',
    'EMAIL_NEW_TICKET_TEXT'          => 'Создан новый тикет – <a href="%s">%s</a>.<br>',
    'EMAIL_NEW_ANSWER_TICKET_SUBJECT' => 'Добавлен новый ответ к тикету',
    'EMAIL_NEW_ANSWER_TICKET_TEXT'    => 'Добавлен новый ответ к тикету – <a href="%s">#%s</a>.<br>',
    'EMAIL_CONFIRM_USER_DELETE'      => 'Подтвердите удаление пользователя',
    'EMAIL_CONFIRM_USER_DELETE_TEXT' => 'Код подтверждения <strong>%s</strong> по тикету <strong>#<a href="%s">%s</a></strong>.' . $emailFooter,
    'EMAIL_NEW_LOGIN_SUBJECT'        => 'Авторизация на сайте «ArtInWeb CMS»',
    'EMAIL_NEW_LOGIN_TEXT'           => 'На сайте «ArtInWeb CMS» кто-то вошёл под Вашим логином и паролем.<br><br><strong>ЕСЛИ ЭТО БЫЛИ НЕ ВЫ:</strong><br> немедленно измените свой пароль для входа на сайт «ArtInWeb CMS».<br>Форма для получения нового пароля доступна по ссылке ниже.',
    'EMAIL_NEW_REVIEW_SUBJECT'    => 'На сайте добавлен новый отзыв',
    'EMAIL_NEW_REVIEW_TEXT'       => 'На сайте добавлен новый отзыв.<br><br>Модерировать отзыв:<br><br><a href="%s">%s</a>',
];
