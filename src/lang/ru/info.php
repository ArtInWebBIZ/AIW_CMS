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
    'INFO_USER_PASSWORD_DEMANDS'     => 'Пароль пользователя может содержать цифры, буквы английского алфавита верхнего, нижнего регистров, но не меньше <strong>%s</strong>, и не больше <strong>%s</strong> символов.',
    'INFO_USER_EMAIL'                => 'Адрес электронной почты пользователя <em>(email)</em> должен содержать не меньше <strong>%s</strong>, и не больше <strong>%s</strong> символов.',
    'INFO_USER_EMAIL_DEMANDS'        => '<strong><span class="uk-text-danger">Указывайте только адрес электронной почты, которым РЕАЛЬНО пользуетесь!</span><br><br>Не активировав свой профиль через указанный здесь адрес электронной почты <em>(email)</em>, вы <span class="uk-text-danger">НЕ СМОЖЕТЕ</span> каким либо образом пользоваться этим сайтом, кроме просмотра общедоступной информации.</strong><br><br>Адрес электронной почты пользователя <em>(email)</em> должен содержать не меньше <strong>%s</strong>, и не больше <strong>%s</strong> символов.',
    'INFO_USER_NAME'                 => '<strong>В этом поле указывайте ТОЛЬКО ИМЯ</strong>&nbsp;!<br><br>Имя может содержать не меньше <strong>%s</strong> и не больше <strong>%s</strong> символов.',
    'INFO_USER_LASTNAME'             => 'Ваше отчество.<br><br>Отчество может содержать не меньше <strong>%s</strong> и не больше <strong>%s</strong> символов.',
    'INFO_USER_SURNAME'              => 'Ваша фамилия.<br><br>Фамилия может содержать не меньше <strong>%s</strong> и не больше <strong>%s</strong> символов.',
    'INFO_DEPARTMENT_NUMBER'      => 'Номер отделения.<br><br>Номер отделения <strong>должен состоять только из цифр</strong>, может содержать не меньше <strong>%s</strong> и не больше <strong>%s</strong> символов и <strong>не может быть равен 0</strong>.',
    'INFO_DEPARTMENT_ADDRESS'     => 'Адрес отделения.<br><br>Адрес отделения <strong>(область, район области, город (СГТ, село), улица и номер дома)</strong>. Адрес отделения может содержать не меньше <strong>%s</strong> и не больше <strong>%s</strong> символов.',
    'INFO_USER_PHONE'                => '<strong>Ваш телефон.</strong><br><br>Номер телефона может содержать <strong>ТОЛЬКО ЦИФРЫ</strong>, <em>включая код страны <strong>(без знака "+")</strong></em>, без пробелов и других символов.',
    'INFO_ARCHIVE_LINK'              => 'Линк на архив с фотографиями.<br><br>Линк на архив с фотографиями может содержать не меньше <strong>%s</strong> и не больше  <strong>%s</strong> символов.<br><br>Разместите архив с Вашими фото на Вашем <a href="https://drive.google.com/drive/my-drive" target="_blank" rel="noopener noreferrer">Google-диске</a>, дайте к нему доступ, и разместите здесь ссылку на этот архив.<br><br>Или, вышлите архив с Вашими фото на наш <a href="https://t.me/photosbizua" target="_blank" rel="noopener noreferrer">Telegram</a>, и в этом поле просто напишите <strong>telegram</strong>.<br><br><strong>!!! АРХИВИРОВАТЬ ФОТО ОБЯЗАТЕЛЬНО !!!</strong>',
    'INFO_USER_PHONE_ACCESS'         => 'Ваш номер телефона защищён согласно с <a href="/doc/privacy-policy.html">"Политикой конфиденциальности"</a> нашего сайта.<br><br><strong>Ваш номер телефона можете видеть только Вы и администрация сайта для уточнения деталей заказа, оплаты, доставки и т.п..</strong>.',
    'INFO_USER_EMAIL_ACCESS'         => 'Ваш email защищён согласно с <a href="/doc/privacy-policy.html">"Политикой конфиденциальности"</a> нашего сайта.<br><br><strong>Ваш email можете видеть только Вы</strong>.<br><br>Ваш email на этом сайте используется <strong>исключительно для возможности восстановления</strong> (или изменения) <strong>пароля</strong> для входа на этот сайт.<br><br><span class="uk-text-danger">Просим учесть, что, если Вы укажете <strong>НЕ СУЩЕСТВУЮЩИЙ</strong> адрес электронной почты, или такой, <strong>к которому Вы не имеете доступа</strong>, Вы <strong>НЕ СМОЖЕТЕ восстановить доступ к своему профилю на этом сайте</strong></span>.',
    'INFO_NO_CORRECT_FIELD_VALUE'    => 'Не корректное значение поля ',
    'INFO_CLEAR_FILTERS'             => 'Очистить фильтры',
    'INFO_INCORRECT_DOWNLOAD_IMAGE'  => 'Изображение загружено с ошибками',
    'INFO_INCORRECT_IMAGE_SIZE'      => 'Размер (вес) загруженного изображения больше допустимого',
    'INFO_INCORRECT_IMAGE_EXTENSION' => 'Не корректный тип загружаемого файла',
    'INFO_IMAGE_NOT_DOWNLOAD'        => 'Изображение не было загружено',
    'INFO_COUNT_10X15_PHOTO'         => 'Количество фотографий <strong>10х15</strong> см.<br><br>Общее количество фотографий 10х15 см. может содержать <strong>только цифры</strong>. Число не может состоять меньше чем из <strong>%s</strong>, и не больше чем из <strong>%s</strong> цифр.<br><br>Стоимость одного фото формата 10х15 см. составляет <strong>%s</strong> грн.<br><br>Если вы не заказываете фотографий этого размера, поставьте <strong>0</strong>.',
    'INFO_COUNT_13X18_PHOTO'         => 'Количество фотографий <strong>13х18</strong> см.<br><br>Общее количество фотографий 13х18 см. может содержать <strong>только цифры</strong>. Число не может состоять меньше чем из <strong>%s</strong>, и не больше чем из <strong>%s</strong> цифр.<br><br>Стоимость одного фото формата 13х18 см. составляет <strong>%s</strong> грн.<br><br>Если вы не заказываете фотографий этого размера, поставьте <strong>0</strong>.',
    'INFO_COUNT_A4_PHOTO'            => 'Количество фотографий <strong>A4</strong>.<br><br>Общее количество фотографий A4 может содержать <strong>только цифры</strong>. Число не может состоять меньше чем из <strong>%s</strong>, и не больше чем из <strong>%s</strong> цифр.<br><br>Стоимость одного фото формата A4 составляет <strong>%s</strong> грн.<br><br>Если вы не заказываете фотографий этого размера, поставьте <strong>0</strong>.',
    'INFO_CROP_PHOTO'                => '<strong>Кадрирование фотографий</strong><br><br>Кадрирование, это выбор редактором в ручном режиме лучшего сюжета фото согласно пропорций бумаги, на которой это фото будет печататься.',
    'INFO_PASSRESET' => 'Адрес электронной почты указанный вами при регистрации на этом сайте.',
    'INFO_IF_USE_INCORRECT_EMAIL_OR_PHONE' => 'Если Вы указываете <strong>НЕ КОРРЕКТНЫЕ</strong> «Адрес электронной почты» или «Телефон» – Ваш доступ к этому сайту может быть закрыт Вами же <strong>НАВСЕГДА!</strong>',
    'INFO_TO_CHOOSE_A_PHOTO' => '<strong>Добавить фото в заказ</strong><br><br>Для выбора на компьютере нескольких фото одновременно, зажмите клавишу <strong><em>«Ctrl»</em></strong>. На смартфонах - нажмите и удерживайте первое фото, а потом выбирайте по очереди нужные.<br><br><strong>Оптимально за один раз добавлять до 5 фото.</strong>',
    'INFO_COPIES_AMOUNT' => '<strong>Количество копий</strong><br><br>Укажите, сколько копий каждого фото из тех, что сейчас будут загружены, должно быть напечатано.',
];
