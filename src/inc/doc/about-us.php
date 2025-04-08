<?php

defined('AIW_CMS') or die;

use Core\Trl;

?>
<h1 class="uk-text-center" itemprop="name"><?= Trl::_('OV_SITE_FULL_NAME') ?></h1>
<div class="uk-margin-medium uk-flex uk-flex-middle uk-margin" uk-grid>
    <div class="uk-width-expand" uk-lightbox>
        <a href="/img/about.jpg">
            <img alt="<?= Trl::_('OV_USER_NAME') ?>" src="/img/about.jpg" class="intro-image" itemprop="image">
        </a>
    </div>
    <div class="uk-width-1-1 uk-margin-medium uk-width-1-2@s uk-text-center">
        <h3 class="contact-h3" itemprop="name"><?= Trl::_('OV_USER_NAME') ?></h3>
        <p class="uk-text-center uk-text-italic">
            <span class="profession" itemprop="jobTitle"><?= Trl::_('OV_GUIDES') ?></span><br>
            <span itemprop="address"><?= Trl::_('OV_REGION') ?></span><br>
            <span itemprop="workLocation"><?= Trl::_('OV_COUNTRY') ?></span><br>
            <a itemprop="telephone" href="tel:+380664806767">+38 066 480 6767</a> / <a href="https://wa.me/380664806767?text=<?= Trl::_('CONTACTS_CONSULTING_MSG') ?>">WhatsApp</a> / <a href="viber://chat?number=%2B380664806767">Viber</a>
        </p>
    </div>
</div>
