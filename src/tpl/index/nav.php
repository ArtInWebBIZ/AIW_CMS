<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Trl};
use Core\Modules\LineMenu\LineMenu;

$cardClass = 'uk-card uk-card-small uk-card-body';

?>
<nav class="uk-container uk-container-large">
    <div class="uk-flex uk-flex-center uk-flex-middle nav-div uk-child-width-expand@s uk-text-center" uk-grid>
        <div>
            <div class="<?= $cardClass ?>">
                <a class="uk-navbar-item uk-logo" href="<?= BaseUrl::getLangToLink() ?>">
                    <img src="/img/logo_h80.png" alt="">
                </a>
            </div>
        </div>
        <div class="uk-visible@m">
            <div class="<?= $cardClass ?>">
                <?= LineMenu::getMenuView() ?>
            </div>
        </div>
        <div class="uk-visible@m">
            <div class="<?= $cardClass ?> uk-text-small">
                <a itemprop="telephone" href="tel:+380664806767">+38 066 480 6767</a><br>
                <a href="https://wa.me/380664806767?text=<?= Trl::_('CONTACTS_CONSULTING_MSG') ?>">WhatsApp</a> /
                <a href="viber://chat?number=%2B380664806767">Viber</a>
            </div>
        </div>
    </div>
</nav>
