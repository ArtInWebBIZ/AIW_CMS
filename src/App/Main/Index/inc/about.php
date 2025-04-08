<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Trl};
use Core\Plugins\Ssl;

$linkToPage = Ssl::getLinkLang() . 'doc/about-us.html';

?>
<section class="uk-section uk-section-small uk-margin-large-top">
    <div class="uk-container uk-container-xlarge">
        <div class="uk-child-width-expand@s uk-flex uk-flex-middle" uk-grid uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 500">
            <div>
                <div class="uk-card uk-card-body" uk-scrollspy="cls: uk-animation-slide-left; repeat: true">
                    <h2 class="uk-text-center"><?= Trl::_('FP_WELCOME') ?></h2>
                    <p class="uk-text-center"><?= Trl::_('FP_WELCOME_TEXT') ?></p>
                    <p class="uk-text-right"><a href="<?= $linkToPage ?>"><?= Trl::_('OV_ABOUT_US') ?></a></p>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-body" uk-scrollspy="cls: uk-animation-slide-right; repeat: true">
                    <a href="<?= $linkToPage ?>">
                        <img class="intro-image" data-src="/img/about_us/mu-1-2x3.jpg" alt="" uk-img="" src="/img/about_us/mu-1-2x3.jpg">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
