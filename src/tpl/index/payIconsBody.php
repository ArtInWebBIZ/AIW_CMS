<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;

?>
<div class="pay-icons-body uk-flex uk-flex-center uk-flex-middle uk-padding-small">
    <ul class="list-unstyled pay-methods uk-margin-remove-bottom uk-flex uk-flex-center uk-flex-wrap">
        <li title="<?= Trl::_('BANK_CARD') ?>">
            <img src="/img/pay-icons/card.png">
        </li>
        <li title="<?= Trl::_('BANK_DELAY') ?>">
            <img src="/img/pay-icons/delay.png">
        </li>
        <li title="<?= Trl::_('BANK_QR_CODE') ?>">
            <img src="/img/pay-icons/qrCode.png">
        </li>
        <li title="Visa Checkout">
            <img src="/img/pay-icons/visaCheckout.png">
        </li>
        <li title="Masterpass">
            <img src="/img/pay-icons/masterPass.png">
        </li>
        <li title="Bot">
            <img src="/img/pay-icons/bot.png">
        </li>
        <li title="Google Pay">
            <img src="/img/pay-icons/googlePay.png">
        </li>
        <li title="Apple Pay">
            <img src="/img/pay-icons/applePay.png">
        </li>
        <li title="<?= Trl::_('BANK_CASH') ?>">
            <img src="/img/pay-icons/bankCash.png">
        </li>
    </ul>
</div>
