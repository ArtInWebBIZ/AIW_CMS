<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Trl};

?>
<div class="uk-width-1-1 uk-width-1-2@s uk-width-1-3@m uk-text-center uk-text-right@m">
    <h3><?= Trl::_('OV_INFORMATION') ?></h3>
    <ul class="uk-list">
        <li><a href="<?= BaseUrl::getLangToLink() ?>doc/privacy-policy.html"><?= Trl::_('DOC_PRIVACY_POLICY') ?></a></li>
        <li><a href="<?= BaseUrl::getLangToLink() ?>doc/site-terms-of-use.html"><?= Trl::_('DOC_SITE_TERMS_OF_USE') ?></a></li>
        <li><a href="<?= BaseUrl::getLangToLink() ?>doc/terms-of-cookies.html"><?= Trl::_('DOC_TERMS_OF_USE_OF_COOKIES') ?></a></li>
        <li><a href="<?= BaseUrl::getLangToLink() ?>doc/html-tags.html"><?= Trl::_('DOC_HTML_TAGS') ?></a></li>
    </ul>
</div>
