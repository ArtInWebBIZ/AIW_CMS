<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Trl};
use Core\Plugins\Ssl;

$linkToPage = Ssl::getLinkLang() . 'doc/about-us.html';

?>
<hr class="uk-divider-icon uk-margin-large-top uk-margin-remove-bottom">
<section class="uk-section uk-section-small uk-margin-large-top">
    <div class="uk-container uk-container-xlarge">
        <div class="uk-child-width-expand@s uk-flex uk-flex-middle" uk-grid uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 500">
            <div>
                <div class="uk-card uk-card-body" uk-scrollspy="cls: uk-animation-slide-left; repeat: true">
                    <h2 class="uk-text-center"><?= Trl::_('MAIN_01') ?></h2>
                    <p><?= Trl::_('MAIN_01_TEXT') ?></p>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-body" uk-scrollspy="cls: uk-animation-slide-right; repeat: true">
                    <a href="<?= $linkToPage ?>">
                        <img class="" data-src="/img/logo_w790.jpg" alt="" uk-img="" src="/img/logo_w790.jpg">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
