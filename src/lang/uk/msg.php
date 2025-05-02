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
    /**
     * msg / alert
     */
    'MSG_DANGER'                      => 'Небезпека',
    'MSG_WARNING'                     => 'Попередження',
    'MSG_MESSAGE'                     => 'Повідомлення',
    'MSG_EMPTY'                       => 'Пусте повідомлення',
    'MSG_COOKIE_MSG'                  => 'Для правильної роботи цього веб-сайту потрібно використовувати файли cookie. Ви можете прочитати більше про <a href="/doc/terms-of-cookies.html">cookie-файли</a> або змінити налаштування вашого браузера.<br><br><strong>Продовжуючи користуватися цим сайтом, не змінюючи налаштувань вашого браузера, ви погоджуєтесь з нашою <a href="/doc/privacy-policy.html">Політикою конфіденційності</a>, <a href="/doc/site-terms-of-use.html">Умовами використання сайту</a> і дайте згоду на використання ваших <a href="/doc/terms-of-cookies.html">cookie-файлів</a>.</strong>',
    'MSG_NO_RESULT'                   => 'Не знайдено записів, що відповідають умовам вибраних фільтрів',
    'MSG_NO_POSTS'                    => 'Немає записів у цьому розділі сайту',
    'MSG_SAVE_CHANGE_ERROR'           => 'При записі змін стався збій. Спробуйте заповнити та надіслати форму ще раз.',
    'MSG_SAVE_TO_DATABASE_ERROR'      => 'При записі у базу даних відбувся збій. Спробуйте заповнити та надіслати форму ще раз.',
    'MSG_FILE_SIZE_EXCEEDED'          => 'Перевищено розмір файлу, що завантажується.',
    'MSG_FILE_RECEIVED_PARTIALLY'     => 'Файл було отримано лише частково.',
    'MSG_FILE_WAS_NOT_LOADED'         => 'Файл не було завантажено.',
    'MSG_NO_TEMPORARY_DIRECTORY'      => 'Файл не завантажений – відсутня тимчасова директорія.',
    'MSG_FAILED_WRITE_FILE_TO_DISK'   => '%s - Не вдалося записати файл на диск.',
    'MSG_FAILED_WRITE_FILE_TO_DB'     => '%s - Не вдалося записати файл у базу даних.',
    'MSG_FAILED_WRITE_THUMB_TO_DISK'  => '%s - Не вдалося записати мініатюру зображення на диск.',
    'MSG_PHP_STOPPED_FILE_UPLOAD'     => 'PHP-розширення зупинило завантаження файлу.',
    'MSG_DIRECTORY_DOES_NOT_EXIST'    => 'Файл не був завантажений – директорія не існує.',
    'MSG_MAXIMUM_FILE_SIZE_EXCEEDED'  => 'Перевищено максимальний розмір файлу.',
    'MSG_FILE_TYPE_IS_PROHIBITED'     => 'Цей тип файлу заборонено.',
    'MSG_ERROR_COPYING_FILE'          => 'Помилка під час копіювання файлу.',
    'MSG_UNKNOWN_ERROR'               => 'Файл не був завантажений – невідома помилка.',
    'MSG_INVALID_FILE_TYPE'           => '%s - Неприпустимий тип файлу.',
    'MSG_INVALID_CONTROLLER_URL'      => 'Такий URL контролера вже існує',
    'MSG_ERROR_CONTROLLER_URL'        => 'Такого URL контролера не існує',
    'MSG_EDIT_NOTE_ERROR'             => 'Цей контент зараз редагується іншим користувачем',
    'MSG_ERROR_SAVE_TO_USER_EDIT_LOG' => 'Збій запису у лог змін',
];
