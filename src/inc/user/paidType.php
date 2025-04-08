<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

return [
    'BALANCE_PHOTO_PAID'         => 0, // + 5 оплата заказа № - 70% от суммы заказа на счёт компании (ID ЗАКАЗА)
    'BALANCE_OBTAINING_INTEREST'   => 1, // + получение процентов на счёт старшего участника
    'BALANCE_PAID_PERCENT'         => 2, // - оплата процентов СО СЧЁТА ПОЛЬЗОВАТЕЛЯ на счёт старшего участника
    'BALANCE_ADD_TO_USERS_ACCOUNT' => 3, // + пополнение счёта пользователя
    'BALANCE_PAID_TO_USER_CARD'    => 4, // - оплата на карту пользователя СО СЧЁТА ПОЛЬЗОВАТЕЛЯ
    'BALANCE_PHOTO_PAID_MASTER'  => 5, // - 0 оплата заказа СО СЧЁТА ПОЛЬЗОВАТЕЛЯ на счёт компании
];
