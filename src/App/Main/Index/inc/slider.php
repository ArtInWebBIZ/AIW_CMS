<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\BaseUrl;

defined('AIW_CMS') or die;

?>
<div class="uk-section">
    <div class="uk-container">
        <a href="<?= BaseUrl::getLangToLink() ?>doc/about-us.html">
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="animation: fade; autoplay: true">
                <div class="uk-slideshow-items">
                    <div>
                        <img src="/img/slider/slider-01.jpg" alt="" uk-cover>
                    </div>
                    <div>
                        <img src="/img/slider/slider-02.jpg" alt="" uk-cover>
                    </div>
                    <div>
                        <img src="/img/slider/slider-03.jpg" alt="" uk-cover>
                    </div>
                    <div>
                        <img src="/img/slider/slider-04.jpg" alt="" uk-cover>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
