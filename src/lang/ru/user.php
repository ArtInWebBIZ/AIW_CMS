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
    'USER_USERS'                         => 'Пользователи',
    'USER_MENU'                          => 'Меню пользователя',
    /**
     * groups
     */
    'USER_GROUP'                         => 'Группа пользователя',
    'USER_GROUP_NOT_SELECTED'            => '- Группа пользователя не выбрана -',
    'USER_GUEST'                         => 'Гость',
    'USER_USER'                          => 'Пользователь',
    'USER_PARTICIPANT'                   => 'Участник',
    'USER_MANAGER'                       => 'Менеджер',
    'USER_MODERATOR'                     => 'Модератор',
    'USER_SUPER_USER'                    => 'Супер юзер',
    'USER_AUTHOR'                        => 'Автор',
    /**
     * status
     */
    'USER_STATUS'                        => 'Статус пользователя',
    'USER_STATUS_NOT_SELECTED'           => 'Статус пользователя не выбран',
    'USER_BLOCK'                         => 'Блокировка пользователя',
    'USER_NOT_ACTIVATED'                 => 'Не активирован',
    'USER_ACTIVE'                        => 'Активен',
    'USER_BLOCKED'                       => 'Заблокирован',
    'USER_GROUP_DOES_NOT_EXIST'          => 'Такой группы пользователей не существует',
    'USER_GROUP_NO_ACCESS_TO_REG'        => 'У вас нет прав регистрировать пользователя в этой группе',
    /**
     * add
     */
    'USER_ADD'                           => 'Регистрация',
    'USER_NAME'                          => 'Имя',
    'USER_MIDDLE_NAME'                   => 'Отчество',
    'USER_NAME_YOUR'                     => 'Ваше имя',
    'USER_SURNAME'                       => 'Фамилия',
    'USER_EMAIL'                         => 'Email',
    'USER_PHONE'                         => 'Телефон',
    'USER_AVATAR'                        => 'Лого или аватар',
    'USER_AVATAR_DELETE'                 => 'Удалить лого или аватар',
    'USER_YOUTUBE'                       => 'YouTube канал',
    'USER_WEBSITE'                       => 'Вебсайт',
    'USER_SOC_NET_PAGE'                  => 'Страница в соц. сетях',

    'USER_PHONE_YOUR'                    => 'Ваш телефон',
    'USER_EMAIL_YOUR'                    => 'Ваш email',
    'USER_EMAIL_ALREADY_EXISTS'          => 'Пользователь с таким адресом email уже существует',
    'USER_PHONE_ALREADY_EXISTS'          => 'Пользователь с таким номером телефона уже существует',
    'USER_EMAIL_OR_PHONE_ALREADY_EXISTS' => 'Пользователь с таким адресом email или номером телефона уже существует',
    'USER_PASSWORD'                      => 'Пароль',
    'USER_OLD_PASSWORD'                  => 'Старый пароль',
    'USER_NEW_PASSWORD'                  => 'Новый пароль',
    'USER_SEND_NEW_PASSWORD'             => 'Выслать новый пароль',
    'USER_PASSWORD_CONFIRM'              => 'Подтвердите пароль',
    'USER_NEW_PASSWORD_CONFIRM'          => 'Подтвердите новый пароль',
    'USER_NAME_NO_MIN'                   => 'В имени пользователя не может быть меньше %s символов.',
    'USER_NAME_NO_MAX'                   => 'В имени пользователя не может быть больше %s символов.',
    'USER_EMAIL_NO_CORRECT'              => 'Не корректный адрес электронной почты',
    'USER_EMAIL_NO_MIN'                  => 'Адрес email не может содержать меньше %s символов.',
    'USER_EMAIL_NO_MAX'                  => 'Адрес email не может содержать больше %s символов.',
    'USER_PASSWORD_NO_MIN'               => 'Пароль пользователя должен содержать буквы английского алфавита верхнего, нижнего регистров и цифры, но не может содержать меньше <strong>%s</strong> символов.',
    'USER_PASSWORD_NO_MAX'               => 'Пароль пользователя должен содержать буквы английского алфавита верхнего, нижнего регистров и цифры, но не может содержать больше <strong>%s</strong> символов.',
    'USER_PASS_NO_CONFIRM'               => 'Пароли не совпадают.',
    'USER_REGISTER_SUCCESS'              => 'Здравствуйте!<br><br><strong>Поздравляем, Вы успешно зарегистрировались!</strong><br><br>Чтобы начать пользоваться этим сайтом, проверьте указанный при регистрации адрес email, и активируйте свой профиль: войдите на сайт используя свой email и пароль, указанный в письме.',
    'USER_PLEASE_ACTIVATE_PROFILE'       => 'Вы уже зарегистрированы.<br>Чтобы начать пользоваться этим сайтом, проверьте свой ящик электронной почты, и активируйте свой профиль: войдите на сайт используя свой email и пароль, указанный в письме.',
    'USER_IN_MENU_ACTIVATE_PROFILE'      => 'Чтобы начать пользоваться этим сайтом, проверьте свой ящик электронной почты, и активируйте свой профиль: войдите на сайт используя свой email и пароль, указанный в письме.',
    'USER_INCORRECT_ACTIVATION_CODE'     => 'Не корректный код активации',
    'USER_CORRECT_ACTIVATION'            => 'Ваш адрес email подтверждён, и Ваш профиль успешно активирован.',
    'USER_ACTIVATION'                    => 'Активация профиля пользователя',
    'USER_NO_CORRECT_EMAIL_PASSWORD'     => 'Не корректный email или пароль',
    'USER_ADD_END_TIME_SESSION'          => 'Истекло время сессии для регистрации нового пользователя. Попробуйте ещё раз заполнить форму регистрации нового пользователя.',
    'USER_NO_CORRECT_ADD'                => 'Ваш профиль не был корректно добавлен, поэтому, попробуйте ещё раз заполнить форму регистрации нового пользователя.',
    'USER_BAN_ADD_NEW_USER_FROM_THIS_IP' => 'С целью предотвращения фиктивных регистраций, регистрация пользователей с одного IP-адреса разрешается только один раз в %s часов.<br><br>С вашего IP-адреса недавно уже был зарегистрирован новый пользователь.<br><br>Если это были вы, <strong>активируйте свой профиль: войдите на сайт используя свой email и пароль, указанный в письме</strong>.',
    /**
     * access
     */
    'USER_EDIT'                          => 'Редактировать пользователя',
    'USER_PROFILE'                       => 'Профиль пользователя',
    'USER_EDIT_PROFILE'                  => 'Редактировать профиль',
    /**
     * login
     */
    'USER_LOGIN'                         => 'Логин',
    'USER_LOGOUT'                        => 'Выйти',
    /**
     * pass-reset
     */
    'USER_RESET_PASSWORD'                => 'Забыли пароль?',
    'USER_SEND_RESET_PASSWORD_SUCCESS'   => 'Новый пароль успешно отправлен на указанный вами email.<br>Чтобы активировать новый пароль, перейдите по ссылке, указанной в письме.<br>Новый пароль будет действителен в продолжении %s минут.',
    'USER_SENDING_NEW_PASSWORD'          => 'На указанный вами email уже был выслан новый пароль.',
    'USER_NEW_RESET_PASSWORD_SESSION'    => 'На указанный вами email уже был выслан новый пароль.<br>Следующий новый пароль может быть выслан только через %s минут.',
    'USER_NO_CORRECT_RESET_CODE'         => 'Не корректный код активации нового пароля',
    'USER_END_TIME_SESSION'              => 'Уже закончилось время сессии, во время которого вам был отправлен новый пароль.<br>Если вам по прежнему нужно получить новый пароль для доступа к своему аккаунту, получите новый пароль ещё раз, и активируйте его <strong>через этот же браузер и не более чем через %s минут</strong>.',
    'USER_RESET_PASSWORD_SUCCESS'        => 'Ваш новый пароль успешно изменён и активирован.<br>Вы можете войти в свой аккаунт используя свой email и новый пароль.',
    'USER_CHANGE_PASSWORD_SUCCESS'       => 'Ваш пароль успешно изменён.',
    /**
     * profile
     */
    'USER_ID'                            => 'ID пользователя',
    'USER_IP'                            => 'IP пользователя',
    'USER_MODERATORS_ID'                 => 'ID модератора',
    'USER_BEING_EDITED'                  => 'Профиль этого пользователя сейчас кем-то редактируется',
    'USER_REGISTRATION_DATE'             => 'Дата регистрации',
    'USER_EDITED'                        => 'Отредактирован',
    'USER_LATEST_VISIT'                  => 'Был на сайте',
    /**
     * edit
     */
    'USER_EDIT_HISTORY_USERS'            => 'История редактирования пользователей',
    'USER_EDIT_TIME_OUT'                 => 'Вы не можете редактировать этого пользователя, или время редактирования этого пользователя уже вышло. Попробуйте заполнить форму редактирования ещё раз.',
    'USER_EDIT_OK'                       => 'Профиль пользователя отредактирован',
    'USER_CHANGE_PASSWORD'               => 'Изменить пароль',

    'USER_NO_CORRECT_EXTENSION'          => 'Файлы с таким расширением не могут быть загружены в качестве аватара пользователя',
    'USER_INCORRECT_EMAIL_PHONE_DATA'    => 'Параметры профиля пользователя <strong>«Адрес электронной почты»</strong> и <strong>«Телефон»</strong> не могут быть изменены одновременно',
    'USER_EDITED_EMAIL_OR_PHONE_DATA'    => 'Ваш <strong>«Адрес электронной почты»</strong> или <strong>«Телефон»</strong> были изменены. Чтобы подтвердить новый <strong>«Адрес электронной почты»</strong> или <strong>«Телефон»</strong> перейдите по соответствующей ссылке в письме от нашего сервиса на Ваш <strong>«Адрес электронной почты»</strong>.',
    /**
     * control
     */
    'USER_CONTROL'                       => 'Управление пользователями',
    'USER_CREATED_FROM'                  => 'Дата регистрации - <span class="uk-text-small uk-text-muted">(позже чем…)</span>',
    'USER_CREATED_TO'                    => 'Дата регистрации - <span class="uk-text-small uk-text-muted">(раньше чем…)</span>',
    'USER_EDITED_FROM'                   => 'Дата редактирования - <span class="uk-text-small uk-text-muted">(позже чем…)</span>',
    'USER_EDITED_TO'                     => 'Дата редактирования - <span class="uk-text-small uk-text-muted">(раньше чем…)</span>',
    'USER_NOT_SELECTED'                  => 'Пользователь не выбран',
    'USER_SELECT'                        => 'Выбрать пользователя',
    /**
     * type
     */
    'USER_TYPE'     => 'Тип пользователя',
    'USER_PERSON'   => 'Человек',
    'USER_BUSINESS' => 'Бизнес',
];
