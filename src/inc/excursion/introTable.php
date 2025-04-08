<?php

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item\AllItemFields;
use Core\Plugins\Dll\Excursion;
use Core\Trl;

$undefined = 'Undefined key ';

$vType       = isset($v['type']) ?
    Excursion::getI()->type($v['type']) :
    $undefined . '$v[\'type\']';

$vFromPlace  = isset($v['from_place']) && is_array($v['from_place']) ?
    Excursion::getI()->place($v['from_place']) :
    $undefined . '$v[\'from_place\']';

$vTransport  = isset($v['transport']) ?
    Excursion::getI()->transport($v['transport']) :
    $undefined . '$v[\'transport\']';

$vPlace      = isset($v['place']) && is_array($v['place']) ?
    Excursion::getI()->place($v['place']) :
    $undefined . '$v[\'place\']';

$vLength     = isset($v['length'])      ? $v['length']            : $undefined . '$v[\'length\']';
$vPrice3     = isset($v['price_3'])     ? (int) $v['price_3']     : $undefined . '$v[\'price_3\']';
$vPrice6     = isset($v['price_6'])     ? (int) $v['price_6']     : $undefined . '$v[\'price_6\']';
$vPriceGroup = isset($v['price_group']) ? (int) $v['price_group'] : $undefined . '$v[\'price_group\']';

?>
<table class="uk-table uk-table-small uk-table-middle intro-table">
    <tr>
        <td class="uk-text-right uk-width-1-2"><?= Trl::_('EXCURSION_TYPE') ?></td>
        <td class="uk-text-bold"><?= $vType ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('EXCURSION_FROM_PLACE') ?></td>
        <td class="uk-text-bold"><?= $vFromPlace ?></td>
    </tr>

    <tr>
        <td class="uk-text-right"><?= Trl::_('EXCURSION_TRANSPORT') ?></td>
        <td class="uk-text-bold"><?= $vTransport ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('EXCURSION_LENGTH') ?></td>
        <td class="uk-text-bold"><?= $vLength ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('EXCURSION_PLACE') ?></td>
        <td class="uk-text-bold"><?= $vPlace ?></td>
    </tr>
    <tr>
        <td class="uk-text-right"><?= Trl::_('EXCURSION_PRICE') ?>&#160;<span class="uk-text-meta">€</span></td>
        <td class="uk-text-bold">
            <?php if (is_int($vPrice3) && $vPrice3 > 0) { ?>
                <span class="uk-inline">
                    <span class="uk-text-primary"><?= $vPrice3 ?></span>
                    <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-alert-success" uk-drop><?= Trl::_('EXCURSION_PRICE_3') ?></div>
                </span>
            <? } ?>
            <?php if ((is_int($vPrice3) && $vPrice3 > 0) && ((is_int($vPrice6) && $vPrice6 > 0) || (is_int($vPriceGroup) && $vPriceGroup > 0))) { ?>
                &#160;/&#160;
            <? } ?>
            <?php if (is_int($vPrice6) && $vPrice6 > 0) { ?>
                <span class="uk-inline">
                    <span class="uk-text-primary"><?= $vPrice6 ?></span>
                    <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-alert-success" uk-drop><?= Trl::_('EXCURSION_PRICE_6') ?></div>
                </span>
            <? } ?>
            <?php if ((is_int($vPrice6) && $vPrice6 > 0) && (is_int($vPriceGroup) && $vPriceGroup > 0)) { ?>
                &#160;/&#160;
            <? } ?>
            <?php if (is_int($vPriceGroup) && $vPriceGroup > 0) { ?>
                <span class="uk-inline">
                    <span class="uk-text-primary"><?= $vPriceGroup ?></span>
                    <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-alert-success" uk-drop><?= Trl::_('EXCURSION_GROUP') ?></div>
                </span>
            <? } ?>
        </td>
    </tr>
</table>
