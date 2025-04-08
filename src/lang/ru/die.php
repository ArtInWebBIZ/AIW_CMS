<?php

/**
 * @package    ArtInWebCMS.lang
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

$endInfo = '<br><br><strong>Вы заблокированы на 15 минут.</strong><br><br><strong>При обращении к сайту до конца блокировки, время блокировки снова начинается с момента крайнего обращения.</strong><br><br>По истечении времени блокировки, эта страница автоматически будет перезагружена, и вы снова можете пользоваться этим сайтом.';

return [
    'DIE_PAGE_RESET'                => 'Для продолжения обновите страницу',
    'DIE_BLOCKED_BY_IP'             => 'Заблокировано по IP',
    'DIE_BLOCKED_BY_IP_INFO'        => 'Количество одновременных соединений с вашего IP-адреса превысило допустимое значение.' . $endInfo . '<br><br><strong>Если у вас появилось это предупреждение - вы либо преступник, и проводите сейчас DDoS атаку на этот сайт, либо ваш браузер не сохраняет файлы cookie. Как решить такую проблему вы можете прочитать <a href="https://support.google.com/accounts/answer/61416" target="_blank" rel="noopener noreferrer">на этой странице</a></strong>.',
    'DIE_ERROR_NEXT_PAGE_TIME'      => 'Заблокировано по времени обращения к сайту',
    'DIE_ERROR_NEXT_PAGE_TIME_INFO' => 'Вы не можете обращаться к сайту чаще, чем через несколько секунд после просмотра предыдущей страницы.',
    'DIE_ERROR_LIMIT_EXCEEDED'      => 'Превышен лимит ошибок',
    'DIE_ERROR_LIMIT_EXCEEDED_INFO' => 'Лимит допущенных вами ошибок в работе с этим сайтом превысил допустимые пределы.' . $endInfo,
    'DIE_ERROR_SESSION_TOKEN'       => 'Заблокировано по сессии пользователя',
    'DIE_ERROR_SESSION_TOKEN_INFO'  => 'Ваша сессия закончена или вы пробуете отправить данные с другого сайта.',
    'DIE_LIMIT_PAGE_VIEWS'          => 'Превышен лимит просмотра страниц сайта',
    'DIE_LIMIT_PAGE_VIEWS_INFO'     => 'Превышен лимит просмотра страниц сайта для не зарегистрированных пользователей.' . $endInfo . '<br><br><strong>Чтобы избежать подобных блокировок в будущем, зарегистрируйтесь и авторизуйтесь</strong>.',
    'DIE_SITE_AVAILABLE_AFTER'      => 'Сайт для вас станет доступным после',
    'DIE_PRESUMABLY'                => 'Предположительно неверный путь к файлу изображения',
    'DIE_PROBABLY'                  => 'ВОЗМОЖНО ошибка возникла здесь',
];
