<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, Content, Trl};

?>
<?= Content::getContentStart('uk-section-large', 'uk-background-default', ' overflow-hidden uk-flex uk-flex-column uk-flex-center') ?>
<h1 class="uk-text-center uk-margin-top uk-margin-large-bottom"><?= Trl::_('DOC_SERVICES_LIST_AND_PRICE') ?></h1>
<table class="uk-table uk-table-small uk-table-striped">
    <tr>
        <td class="uk-text-bold uk-text-center"><?= Trl::_('DOC_SERVICES_LIST') ?></td>
        <td class="uk-text-bold uk-text-center"><?= Trl::_('DOC_PRICE') ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('DOC_PRICE_10X15_LABEL') ?></td>
        <td class="uk-text-bold uk-text-center"><?= Config::getCfg('CFG_PRICE_10X15_PHOTO') ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('DOC_PRICE_13X18_LABEL') ?></td>
        <td class="uk-text-bold uk-text-center"><?= Config::getCfg('CFG_PRICE_13X18_PHOTO') ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('DOC_PRICE_A4_LABEL') ?></em></td>
        <td class="uk-text-bold uk-text-center"><?= Config::getCfg('CFG_PRICE_A4_PHOTO') ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('DOC_PRICE_CROP_LABEL') ?></em></td>
        <td class="uk-text-bold uk-text-center"><?= Config::getCfg('CFG_PRICE_CROP_PHOTO') ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('DOC_MINIMAL_BOOKINGS_SUM') ?></em></td>
        <td class="uk-text-bold uk-text-center"><?= Config::getCfg('CFG_MINIMAL_PHOTO_PRINTS_SUM') ?></td>
    </tr>
    <?php if (Config::getCfg('CFG_SALES_DISCOUNT') > 0) { ?>
        <tr>
            <td class="uk-text-right"><?= Trl::_('DOC_SALE_DISCOUNT') ?></td>
            <td class="uk-text-bold uk-text-center"><?= Config::getCfg('CFG_SALES_DISCOUNT') * 100 ?>%</td>
        </tr>
    <?php } ?>
</table>
<?= Content::getContentEnd() ?>
