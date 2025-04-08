<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl};
use Core\Plugins\Check\Item\ItemImg;

$itemLink = BaseUrl::getLangToLink() . 'blog/' . $v['id'] . '.html';

$cardClass = 'uk-card-body uk-padding-remove uk-flex uk-flex-center uk-flex-middle';

?>
<div class="uk-width-1-1 uk-width-4-5@m uk-width-3-5@xl">
    <div class="uk-card uk-card-body uk-padding-small uk-margin-medium-bottom" uk-scrollspy="cls:uk-animation-fade; repeat: true">
        <div class="div-content uk-grid-match" uk-grid>
            <div class="uk-width-1-1 uk-width-3-5@m">
                <div class="<?= $cardClass ?>">
                    <div>
                        <h2 class="uk-text-center uk-margin-medium-bottom"><a href="<?= $itemLink ?>"><?= $v['heading'] ?></a></h2>
                        <p><?= $v['intro_text'] ?></p>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand">
                <div class="<?= $cardClass ?>">
                    <a href="<?= $itemLink ?>">
                        <img src="<?= ItemImg::getItemImgPath($v['created'], $v['id'], $v['intro_img']) ?>" alt="" class="intro-image">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
