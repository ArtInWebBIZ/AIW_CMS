<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Ssl;
use Core\Trl;

?>
<div class="uk-width-1-1 uk-width-1-3@m uk-text-center uk-text-left@m">
    <h3><?= Trl::_('OV_ABOUT_US') ?></h3>
    <h5 class="uk-text-bold uk-margin-small-top"><?= Trl::_('OV_SITE_FULL_NAME') ?></h5>
    <table class="uk-table-middle footer-table-contacts">
        <tr>
            <td class="uk-margin-small-left"><img src="/img/icons-white/road-sign-both.svg" alt="" class="icon-menu uk-margin-small-right"></td>
            <td><?= Trl::_('OV_COUNTRY') ?>,<br><?= Trl::_('PLACE_LISBON') ?></td>
        </tr>
        <tr>
            <td class="uk-margin-small-left"><img src="/img/icons-white/iphone.svg" alt="" class="icon-menu uk-margin-small-right"></td>
            <td>+351&#160;968&#160;310&#160;387 - (Viber, WhatsApp)</td>
        </tr>
        <tr>
            <td class="uk-margin-small-left"><img src="/img/icons-white/accept-email.svg" alt="" class="icon-menu uk-margin-small-right"></td>
            <td><a href="<?= Ssl::getLinkLang() ?>contacts/"><?= Trl::_('OV_CONTACTS') ?></a></td>
        </tr>
    </table>
</div>
