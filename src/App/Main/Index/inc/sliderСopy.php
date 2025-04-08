<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Trl};

$h1Class = 'uk-heading-medium uk-text-center slider-title uk-text-bold';
$ukPanel = 'uk-position-center slider uk-panel uk-padding-large uk-background-muted border-radius-30px';

?>
<div class="uk-width-1-1 uk-text-center">
    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="center: true; autoplay: true">
        <!-- <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="center: true"> -->

        <div class="uk-slider-items uk-grid uk-grid-match" uk-height-viewport="100vh">
            <div class="uk-width-1-1 uk-animation-fade">
                <div class="uk-cover-container">
                    <img src="/img/slider/slider-01.jpg" alt="" uk-cover>
                    <div class="<?= $ukPanel ?>">
                        <h1 class="<?= $h1Class ?>"><?= Trl::_('MP_01') ?></h1>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1 uk-animation-fade">
                <div class="uk-cover-container">
                    <img src="/img/slider/slider-02.jpg" alt="" uk-cover>
                    <div class="<?= $ukPanel ?>">
                        <h1 class="<?= $h1Class ?>"><?= Trl::_('MP_02') ?></h1>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1 uk-animation-fade">
                <div class="uk-cover-container">
                    <img src="/img/slider/slider-03.jpg" alt="" uk-cover>
                    <div class="<?= $ukPanel ?>">
                        <h1 class="<?= $h1Class ?>"><?= Trl::_('MP_03') ?></h1>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1 uk-animation-fade">
                <div class="uk-cover-container">
                    <img src="/img/slider/slider-04.jpg" alt="" uk-cover>
                    <div class="<?= $ukPanel ?>">
                        <h1 class="<?= $h1Class ?>"><?= Trl::_('MP_04') ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href uk-slidenav-next uk-slider-item="next"></a>

    </div>
</div>
