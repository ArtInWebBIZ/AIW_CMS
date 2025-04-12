<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Router};
use Core\Plugins\Check\Item\ItemImg;

$itemLink = BaseUrl::getLangToLink() . Router::getRoute()['controller_url'] . '/' . $v['id'] . '.html';

$cardClass = 'uk-card-body uk-padding-remove uk-flex uk-flex-center uk-flex-middle';

?>
<div>
    <div class="uk-card uk-card-body">
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
        <hr class="uk-divider-icon">
    </div>
</div>
