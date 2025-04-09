<?php

/**
 * @package    ArtInWebCMS.lang
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

$endInfo = '<br><br><strong>You are blocked for 15 minutes.</strong><br><br><strong>If you access the site before the end of the block, the blocking time starts again from the moment of the last access.</strong><br><br>When the blocking time expires, this page will automatically reload and you will be able to use this website again.';

return [
    'DIE_PAGE_RESET'                => 'To continue, reload the page',
    'DIE_BLOCKED_BY_IP'             => 'Blocked by IP',
    'DIE_BLOCKED_BY_IP_INFO'        => 'The number of simultaneous connections to your IP address has exceeded the allowable value.' . $endInfo . '<br><br><strong>If you see this warning, you are either a criminal and are currently planning a DDoS attack on this site, or your browser does not store cookies.You can read how to solve this problem <a href="https://support.google.com/accounts/answer/61416" target="_blank" rel="noopener noreferrer">on this page</a></strong>.',
    'DIE_ERROR_NEXT_PAGE_TIME'      => 'Blocked by time of access to the site',
    'DIE_ERROR_NEXT_PAGE_TIME_INFO' => 'You cannot access the site more than a few seconds after viewing the previous page.',
    'DIE_ERROR_LIMIT_EXCEEDED'      => 'Error limit exceeded',
    'DIE_ERROR_LIMIT_EXCEEDED_INFO' => 'The number of errors you have made while using this site has exceeded the permissible limits.' . $endInfo,
    'DIE_ERROR_SESSION_TOKEN'       => 'Blocked by user session',
    'DIE_ERROR_SESSION_TOKEN_INFO'  => 'Your session is over or you\'re trying to send data from another site.',
    'DIE_LIMIT_PAGE_VIEWS'          => 'The site page view limit is exceeded',
    'DIE_LIMIT_PAGE_VIEWS_INFO'     => 'The page view limit for unregistered users has been exceeded.' . $endInfo . '<br><br><strong>To avoid such blockages in the future, please register and log in.</strong>',
    'DIE_SITE_AVAILABLE_AFTER'      => 'The site will be available to you after',
    'DIE_PRESUMABLY'                => 'Presumably the wrong way to the image file',
    'DIE_PROBABLY'                  => 'Perhaps the error arose here',
];
