<?php

/**
 * @package    ArtInWebCMS.lang
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

/**
 * !!! Everything inside HTML tags is NOT TRANSLATED !!!
 */

return [
    'USER_USERS'                         => 'Користувачі',
    'USER_MENU'                          => 'Меню користувача',
    /**
     * groups
     */
    'USER_GROUP'                         => 'Група користувача',
    'USER_GUEST'                         => 'Гість',
    'USER_USER'                          => 'Користувач',
    'USER_PARTICIPANT'                   => 'Учасник',
    'USER_MANAGER'                       => 'Менеджер',
    'USER_MODERATOR'                     => 'Модератор',
    'USER_SUPER_USER'                    => 'Супер юзер',
    'USER_AUTHOR'                        => 'Автор',
    /**
     * status
     */
    'USER_STATUS'                        => 'Статус користувача',
    'USER_STATUS_NOT_SELECTED'           => 'Статус користувача не вибрано',
    'USER_BLOCK'                         => 'Блокування користувача',
    'USER_NOT_ACTIVATED'                 => 'Не активований',
    'USER_ACTIVE'                        => 'Активний',
    'USER_BLOCKED'                       => 'Заблокований',
    'USER_GROUP_DOES_NOT_EXIST'          => 'Такої групи користувачів не існує',
    'USER_GROUP_NO_ACCESS_TO_REG'        => 'У вас немає прав реєструвати користувача в цій групі',
    /**
     * add
     */
    'USER_ADD'                           => 'Реєстрація',
    'USER_NAME'                          => 'Ім\'я',
    'USER_MIDDLE_NAME'                      => 'По-батькові',
    'USER_NAME_YOUR'                     => 'Ваше ім\'я',
    'USER_SURNAME'                       => 'Прізвище',
    'USER_EMAIL'                         => 'Email',
    'USER_PHONE'                         => 'Телефон',
    'USER_AVATAR'                        => 'Лого або аватар',
    'USER_AVATAR_DELETE'                 => 'Видалити лого або аватар',
    'USER_YOUTUBE'                       => 'YouTube канал',
    'USER_WEBSITE'                       => 'Вебсайт',
    'USER_SOC_NET_PAGE'                  => 'Сторінка у соц. мережах',
    'USER_PHONE_YOUR'                    => 'Ваш телефон',
    'USER_EMAIL_YOUR'                    => 'Ваш email',
    'USER_EMAIL_ALREADY_EXISTS'          => 'Користувач з такою адресою email вже існує',
    'USER_PHONE_ALREADY_EXISTS'          => 'Користувач з таким номером телефона вже існує',
    'USER_EMAIL_OR_PHONE_ALREADY_EXISTS' => 'Користувач з такою адресою email або номером телефона вже існує',
    'USER_PASSWORD'                      => 'Пароль',
    'USER_OLD_PASSWORD'                  => 'Старий пароль',
    'USER_NEW_PASSWORD'                  => 'Новий пароль',
    'USER_SEND_NEW_PASSWORD'             => 'Вислати новий пароль',
    'USER_PASSWORD_CONFIRM'              => 'Підтвердіть пароль',
    'USER_NEW_PASSWORD_CONFIRM'          => 'Підтвердіть новий пароль',
    'USER_NAME_NO_MIN'                   => 'У імені користувача не може бути менше %s символів.',
    'USER_NAME_NO_MAX'                   => 'У імені користувача не може бути більше %s символів.',
    'USER_EMAIL_NO_CORRECT'              => 'Не коректна адреса електронної пошти',
    'USER_EMAIL_NO_MIN'                  => 'Адреса email не може мати менше %s символів.',
    'USER_EMAIL_NO_MAX'                  => 'Адреса email не може мати більше %s символів.',
    'USER_PASSWORD_NO_MIN'               => 'Пароль користувача повинен містити літери англійського алфавіту верхнього, нижнього регістрів та цифри, але не може містити менше <strong>%s</strong> символів.',
    'USER_PASSWORD_NO_MAX'               => 'Пароль користувача повинен містити літери англійського алфавіту верхнього, нижнього регістрів та цифри, але не може містити більше <strong>%s</strong> символів.',
    'USER_PASS_NO_CONFIRM'               => 'Паролі не співпадають.',
    'USER_REGISTER_SUCCESS'              => 'Привіт!<br><br><strong>Вітаємо, Ви успішно зареєструвалися!</strong><br><br>Щоб почати користуватися цим сайтом, перевірте вказану при реєстрації адресу email, та активуйте свій профіль: увійдіть на сайт використовуючи свій email та пароль, вказаний у листі.',
    'USER_PLEASE_ACTIVATE_PROFILE'       => 'Ви вже зареєстровані.<br>Щоб почати користуватися цим сайтом, перевірте свою скриньку електронної пошти, та активуйте свій профіль: увійдіть на сайт використовуючи свій email та пароль, вказаний у листі.',
    'USER_IN_MENU_ACTIVATE_PROFILE'      => 'Щоб почати користуватися цим сайтом, перевірте свою скриньку електронної пошти, та активуйте свій профіль: увійдіть на сайт використовуючи свій email та пароль, вказаний у листі.',
    'USER_INCORRECT_ACTIVATION_CODE'     => 'Не коректний код активації',
    'USER_CORRECT_ACTIVATION'            => 'Ваша адреса email підтверджена, і Ваш профіль успішно активований.',
    'USER_ACTIVATION'                    => 'Активація профилю користувача',
    'USER_NO_CORRECT_EMAIL_PASSWORD'     => 'Не коректний email або пароль',
    'USER_ADD_END_TIME_SESSION'          => 'Минув час сесії для реєстрації нового користувача. Спробуйте ще раз заповнити форму реєстрації нового користувача.',
    'USER_NO_CORRECT_ADD'                => 'Ваш профіль не був коректно доданий, тому спробуйте ще раз заповнити форму реєстрації нового користувача.',
    'USER_BAN_ADD_NEW_USER_FROM_THIS_IP' => 'З метою запобігання фіктивних реєстрацій, реєстрація користувачів з однієї адреси IP дозволяється лише один раз на %s годин.<br><br>З вашої IP-адреси нещодавно вже був зареєстрований новий користувач.<br><br>Якщо це були ви, <strong>активуйте свій профіль: увійдіть на сайт використовуючи свій email та пароль, вказаний у листі</strong>.',

    /**
     * access
     */
    'USER_EDIT'                          => 'Редагувати користувача',
    'USER_PROFILE'                       => 'Профіль користувача',
    'USER_EDIT_PROFILE'                  => 'Редагувати профіль',
    /**
     * login
     */
    'USER_LOGIN'                         => 'Логін',
    'USER_LOGOUT'                        => 'Вийти',
    /**
     * pass-reset
     */
    'USER_RESET_PASSWORD'                => 'Забули пароль?',
    'USER_SEND_RESET_PASSWORD_SUCCESS'   => 'Новий пароль успішно надіслано на вказаний вами email.<br>Щоб активувати новий пароль, перейдіть за посиланням, вказаним у листі.<br>Новий пароль буде дійсний протягом %s хвилин.',
    'USER_SENDING_NEW_PASSWORD'          => 'На вказаний вами email вже було надіслано новий пароль.',
    'USER_NEW_RESET_PASSWORD_SESSION'    => 'На вказаний вами email вже було надіслано новий пароль.<br>Наступний новий пароль може бути надісланий лише через %s хвилин.',
    'USER_NO_CORRECT_RESET_CODE'         => 'Не коректний код активації нового пароля',
    'USER_END_TIME_SESSION'              => 'Вже закінчився час сесії, під час якого вам був відправлений новий пароль.<br>Якщо вам раніше потрібно отримати новий пароль для доступу до свого облікового запису, отримайте новий пароль ще раз, і активуйте його <strong>через цей же браузер і не більше ніж через %s хвилин</strong>.',
    'USER_RESET_PASSWORD_SUCCESS'        => 'Ваш новий пароль успішно змінено та активовано.<br>Ви можете увійти до свого облікового запису, використовуючи свій email та новий пароль.',
    'USER_CHANGE_PASSWORD_SUCCESS'       => 'Ваш пароль успішно змінено.',
    /**
     * profile
     */
    'USER_ID'                            => 'ID користувача',
    'USER_IP'                            => 'IP користувача',
    'USER_MODERATORS_ID'                 => 'ID модератора',
    'USER_BEING_EDITED'                  => 'Профіль цього користувача зараз кимось редагується',
    'USER_REGISTRATION_DATE'             => 'Дата реєстрації',
    'USER_EDITED'                        => 'Відредагований',
    'USER_LATEST_VISIT'                  => 'Був на сайті',
    /**
     * edit
     */
    'USER_EDIT_HISTORY_USERS'            => 'Історія редагування користувачів',
    'USER_EDIT_TIME_OUT'                 => 'Ви не можете редагувати цього користувача, або час редагування цього користувача вже вийшов. Спробуйте заповнити форму редагування ще раз.',
    'USER_EDIT_OK'                       => 'Профіль користувача відредаговано',
    'USER_CHANGE_PASSWORD'               => 'Змінити пароль',

    'USER_NO_CORRECT_EXTENSION'          => 'Файли з таким розширенням не можуть бути завантажені як аватар користувача',
    'USER_INCORRECT_EMAIL_PHONE_DATA'    => 'Параметри профілю користувача <strong>Адреса електронної пошти</strong> та <strong>Телефон</strong> не можуть бути змінені одночасно',
    'USER_EDITED_EMAIL_OR_PHONE_DATA'    => 'Ваша <strong>«Адреса електронної пошти»</strong> або <strong>«Телефон»</strong> були змінені. Щоб підтвердити нову <strong>«Адресу електронної пошти»</strong> або <strong>«Телефон»</strong>, перейдіть за відповідним посиланням у листі від нашого сервісу на Вашу <strong>«Адресу електронної пошти»</strong>.',
    /**
     * control
     */
    'USER_CONTROL'                       => 'Керування користувачами',
    'USER_CREATED_FROM'                  => 'Дата реєстрації - <span class="uk-text-small uk-text-muted">(пізніше ніж…)</span>',
    'USER_CREATED_TO'                    => 'Дата реєстрації - <span class="uk-text-small uk-text-muted">(раніше ніж…)</span>',
    'USER_EDITED_FROM'                   => 'Дата редагування - <span class="uk-text-small uk-text-muted">(пізніше ніж…)</span>',
    'USER_EDITED_TO'                     => 'Дата редагування - <span class="uk-text-small uk-text-muted">(раніше ніж…)</span>',
    /**
     * type
     */
    'USER_TYPE'     => 'Тип користувача',
    'USER_PERSON'   => 'Людина',
    'USER_BUSINESS' => 'Бізнес',
];
