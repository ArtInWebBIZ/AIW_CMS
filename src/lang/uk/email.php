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

$emailFooter = '<br><br><hr style="border:none; border-bottom:1px solid gold"><br><span style="display:block; font-size:x-small; text-align:center">Якщо при якихось діях на сайті ваш email був вказаний не вами, повідомте про це адміністрацію сайту на сторінці <a href="%s">Контакти</a></span>';

return [
    'EMAIL_CONFIRM'                  => 'Підтвердіть Вашу електронну адресу',
    'EMAIL_CONFIRM_NEW_EMAIL'        => '<b>Вітаємо</b>!<br><br>Щоб підтвердити нову адресу електронної пошти, авторизуйтесь на сайті:<br><br><a href="%s">%s</a>' . $emailFooter,
    'EMAIL_CONFIRM_NEW_PHONE'        => '<b>Вітаємо</b>!<br><br>Щоб підтвердити новий номер телефону, авторизуйтесь на сайті:<br><br><a href="%s">%s</a>' . $emailFooter,
    'EMAIL_CREATE_NEW_USER'          => '<b>Вітаємо</b>!<br><br>Щоб активувати свій профіль, авторизуйтесь на сайті використовуючи вказаний нижче пароль.<br><br><a href="%s">%s</a><br><br>Ваш пароль для входу на сайт: <strong>%s</strong>' . $emailFooter,
    'EMAIL_SEND_NEW_PASSWORD'        => 'Ваш новий пароль: <b>%s</b><br><br>Щоб активувати новий пароль у своєму профілі, перейдіть за посиланням нижче:<br><br><a href="%s">%s</a><br><br>Якщо ви не вимагали нового пароля <strong>НЕ ПЕРЕХОДЬТЕ ЗА ВКАЗАНИМ ПОСИЛАННЯМ</strong>! У цьому випадку ваш старий пароль залишатиметься дійсним.' . $emailFooter,
    'EMAIL_NEW_TICKET_SUBJECT'       => 'Створено новий тікет',
    'EMAIL_NEW_TICKET_TEXT'          => 'Створено новий тікет – <a href="%s">%s</a>.<br>',
    'EMAIL_NEW_ANSWER_TICKET_SUBJECT' => 'Додано нову відповідь до тікету',
    'EMAIL_NEW_ANSWER_TICKET_TEXT'    => 'Додано нову відповідь до тікету – <a href="%s">#%s</a>.<br>',
    'EMAIL_CONFIRM_PAY_TO_CARD'      => 'Підтвердження зняття коштів',
    'EMAIL_CONFIRM_PAY_TO_CARD_TEXT' => 'Код підтвердження <strong>%s</strong> для тікету <strong>#<a href="%s">%s</a></strong>.' . $emailFooter,
    'EMAIL_ERROR_SAVE_TO_USERS_BALANCE_SUBJECT' => 'Помилка під час запису поповнення балансу користувача',
    'EMAIL_ERROR_SAVE_TO_USERS_BALANCE_TEXT' => 'При записі поповнення балансу користувача #%s сталася помилка на одному з трьох етапів:<br>- запису нового значення в баланс профілю користувача;<br>- запису в лог змін профілю користувача;<br>- запису зміни лога балансу користувача.',
    'EMAIL_NEW_LOGIN_SUBJECT'        => 'Авторизація на сайті «Andorinha Portugal Tours»',
    'EMAIL_NEW_LOGIN_TEXT'           => 'На сайті «Andorinha Portugal Tours» хтось зайшов під Вашим логіном та паролем.<br><br><strong>ЯКЩО ЦЕ БУЛИ НЕ ВИ:</strong><br>терміново змініть свій пароль для входу на сайт «Andorinha Portugal Tours».<br>Форма для отримання нового паролю доступна за посиланням нижче.',
    'EMAIL_BALANCE_STAGE_SUBJECT'    => 'Нова сума акумульована на Вашому балансі',
    'EMAIL_BALANCE_STAGE_TEXT'       => 'На Вашому балансі акумульована сума, що дорівнює або більше %s %s',
    'EMAIL_NEW_REVIEW_SUBJECT'    => 'На сайті додано новий відгук',
    'EMAIL_NEW_REVIEW_TEXT'       => 'На сайті додано новий відгук.<br><br>Модерувати відгук:<br><br><a href="%s">%s</a>',
];
