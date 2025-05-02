<?php

/**
 * @package    ArtInWebCMS.lang
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

$endInfo = '<br><br><strong>Ви заблоковані на 15 хвилин.</strong><br><br><strong>При зверненні до сайту до кінця блокування, час блокування знову починається з моменту крайнього звернення.</strong><br><br>Після закінчення часу блокування, ця сторінка автоматично буде перезавантажена, і ви знову зможете користуватись цим веб-сайтом.';

return [
    'DIE_PAGE_RESET'                => 'Для продовження перезавантажте сторінку',
    'DIE_BLOCKED_BY_IP'             => 'Заблоковано по IP',
    'DIE_BLOCKED_BY_IP_INFO'        => 'Кількість одночасних з`єднань з вашою IP-адресою перевищила допустиме значення.' . $endInfo . '<br><br><strong>Якщо у вас з`явилось це попередження – ви або злочинець, і провидите зараз DDoS атаку на цей сайт, або ваш браузер не зберігає файлів cookie. Як вирішити таку проблему ви можете прочитати <a href="https://support.google.com/accounts/answer/61416" target="_blank" rel="noopener noreferrer">на цій сторінці</a></strong>.',
    'DIE_ERROR_NEXT_PAGE_TIME'      => 'Заблоковано за часом звернення до сайту',
    'DIE_ERROR_NEXT_PAGE_TIME_INFO' => 'Ви не можете звертатися до сайту частіше, ніж через кілька секунд після перегляду попередньої сторінки.',
    'DIE_ERROR_LIMIT_EXCEEDED'      => 'Перевищено ліміт помилок',
    'DIE_ERROR_LIMIT_EXCEEDED_INFO' => 'Ліміт допущених вами помилок у роботі з цим сайтом перевищив допустимі межі.' . $endInfo,
    'DIE_ERROR_SESSION_TOKEN'       => 'Заблоковано по сесії користувача',
    'DIE_ERROR_SESSION_TOKEN_INFO'  => 'Ваша сесія закінчена або ви намагаєтеся надіслати дані з іншого сайту.',
    'DIE_LIMIT_PAGE_VIEWS'          => 'Перевищено ліміт перегляду сторінок сайту',
    'DIE_LIMIT_PAGE_VIEWS_INFO'     => 'Перевищено ліміт перегляду сторінок сайту для незареєстрованих користувачів.' . $endInfo . '<br><br><strong>Щоб уникнути таких блокувань у майбутньому, зареєструйтесь та авторизуйтесь.</strong>',
    'DIE_SITE_AVAILABLE_AFTER'      => 'Сайт для вас стане доступним після',
    'DIE_PRESUMABLY'                => 'Імовірно невірний шлях до файлу зображення',
    'DIE_PROBABLY'                  => 'МОЖЛИВО помилка виникла тут',
];
