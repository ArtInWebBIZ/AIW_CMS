<?php

defined('AIW_CMS') or die;

use Core\Plugins\Ssl;
use Core\Trl;

?>
<div itemscope itemtype="https://schema.org/Organization" class="uk-grid-match" uk-grid>
    <div class="uk-width-1-1 uk-width-1-2@m uk-flex uk-flex-middle uk-text-center">
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject" class="uk-card uk-card-body">
            <img itemprop="url image" src="/img/logo_h80.png" />
        </div>
    </div>
    <div class="uk-width-1-1 uk-width-1-2@m uk-flex uk-flex-middle">
        <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="uk-card uk-card-body uk-text-right">
            <h4 itemprop="name" content="<?= Trl::_('OV_OWNER_NAME') ?>" class="uk-text-right"><?= Trl::_('OV_OWNER_NAME') ?></h4>
            <span itemprop="addressCountry"><?= Trl::_('OV_COUNTRY') ?></span>,
            <span itemprop="addressRegion"><?= Trl::_('OV_REGION') ?></span>,<br>
            <a itemprop="telephone" href="tel:+987654321987">+987 654 321 987</a> / <a href="https://wa.me/987654321987?text=<?= Trl::_('CONTACTS_CONSULTING_MSG') ?>">WhatsApp</a> / <a href="viber://chat?number=%2B987654321987">Viber</a>
        </div>
    </div>
    <link itemprop="url" href="<?= Ssl::getLink() ?>">
</div>
