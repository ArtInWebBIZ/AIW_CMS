<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Content;
use Core\Plugins\Check\Item\ItemImg;
use Core\Plugins\Create\Gallery\Gallery;
use Core\Plugins\View\Style;
use Core\Trl;

$cardClass = 'uk-card-body uk-padding-remove uk-flex uk-flex-center uk-flex-middle';

?>
<?= Content::getContentStart(Style::content()['section_css'], Style::content()['container_css'], Style::content()['overflow_css']) ?>
<div itemscope itemtype="http://schema.org/Offer" uk-grid>
    <div>
        <div class="uk-card uk-card-body">
            <p class="uk-text-meta uk-text-right"><span itemprop="seller"><?= Trl::_('OV_SITE_SHORT_NAME') ?> <time itemprop="datePublished" datetime="<?= $v['schema_time'] ?>"></time><?= $v['status'] ?><?= $v['edit_link'] ?></span></p>
            <div class="div-content uk-grid-match" uk-grid>
                <div class="uk-width-1-1 uk-width-3-5@m">
                    <div class="<?= $cardClass ?>">
                        <div>
                            <h1 itemprop="headline" class="uk-text-center"><?= $v['heading'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="uk-width-expand">
                    <div class="<?= $cardClass ?>">
                        <img src="<?= ItemImg::getItemImgPath($v['created'], $v['id'], $v['intro_img']) ?>" alt="" class="intro-image">
                    </div>
                </div>
            </div>
            <article itemprop="articleBody" class="uk-margin-medium-top">
                <p><?= $v['intro_text'] ?></p>
                <?= $v['text'] ?>
                <?= $v['publisher'] ?>
            </article>
        </div>
    </div>
</div>
<?= Gallery::getI()->getGalleryHtml() ?>
<?= Content::getContentEnd() ?>
