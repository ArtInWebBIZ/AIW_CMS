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

return [
    /**
     * msg / alert
     */
    'MSG_DANGER'                      => 'Опасность',
    'MSG_WARNING'                     => 'Предупреждение',
    'MSG_MESSAGE'                     => 'Сообщение',
    'MSG_EMPTY'                       => 'Пустое сообщение',
    'MSG_COOKIE_MSG'                  => 'Этому Сайту для корректной работы необходимо использовать файлы cookie. Вы можете прочитать подробнее о <a href="/doc/terms-of-cookies.html">cookie-файлах</a> или изменить настройки своего браузера.<br><br><strong>Продолжая пользоваться этим сайтом без изменения настроек вашего браузера, вы соглашаетесь с нашей <a href="/doc/privacy-policy.html">Политикой конфиденциальности</a>, <a href="/doc/site-terms-of-use.html">Условиями пользования сайтом</a> и даёте согласие на использование ваших <a href="/doc/terms-of-cookies.html">cookie-файлов</a>.</strong>',
    'MSG_NO_RESULT'                   => 'Не найдено записей, которые соответствуют условиям выбранных фильтров',
    'MSG_NO_POSTS'                    => 'Нет записей в этом разделе сайта',
    'MSG_SAVE_CHANGE_ERROR'           => 'При записи изменений произошёл сбой. Попробуйте заполнить и отправить форму ещё раз',
    'MSG_SAVE_TO_DATABASE_ERROR'      => 'При записи в базу данных произошёл сбой. Попробуйте заполнить и отправить форму ещё раз',
    'MSG_FILE_SIZE_EXCEEDED'          => 'Превышен размер загружаемого файла.',
    'MSG_FILE_RECEIVED_PARTIALLY'     => 'Файл был получен только частично.',
    'MSG_FILE_WAS_NOT_LOADED'         => 'Файл не был загружен.',
    'MSG_NO_TEMPORARY_DIRECTORY'      => 'Файл не загружен - отсутствует временная директория.',
    'MSG_FAILED_WRITE_FILE_TO_DISK'   => '%s - Не удалось записать файл на диск.',
    'MSG_FAILED_WRITE_FILE_TO_DB'     => '%s - Не удалось записать файл в базу данных.',
    'MSG_FAILED_WRITE_THUMB_TO_DISK'  => '%s - Не удалось записать миниатюру изображения на диск.',
    'MSG_PHP_STOPPED_FILE_UPLOAD'     => 'PHP-расширение остановило загрузку файла.',
    'MSG_DIRECTORY_DOES_NOT_EXIST'    => 'Файл не был загружен - директория не существует.',
    'MSG_MAXIMUM_FILE_SIZE_EXCEEDED'  => 'Превышен максимально допустимый размер файла.',
    'MSG_FILE_TYPE_IS_PROHIBITED'     => 'Данный тип файла запрещен.',
    'MSG_ERROR_COPYING_FILE'          => 'Ошибка при копировании файла.',
    'MSG_UNKNOWN_ERROR'               => 'Файл не был загружен - неизвестная ошибка.',
    'MSG_INVALID_FILE_TYPE'           => '%s - Недопустимый тип файла.',
    'MSG_INVALID_CONTROLLER_URL'      => 'Такой URL контроллера уже существует',
    'MSG_ERROR_CONTROLLER_URL'        => 'Такого URL контроллера не существует',
    'MSG_ERROR_SAVE_TO_USER_EDIT_LOG' => 'Сбой записи в лог изменений',
];
