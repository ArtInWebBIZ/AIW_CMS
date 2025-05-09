<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
use Core\Plugins\Check\Item\ItemImg;
use Core\Plugins\Create\Gallery\Gallery;
use Core\Plugins\View\Style;

$style = Style::content();

?>
<?= Content::getContentStart($style['section_css'], $style['container_css'], $style['overflow_css']) ?>
<div itemscope itemtype="http://schema.org/Article" uk-grid>
    <div>
        <div class="uk-card uk-card-body">
            <p class="uk-text-meta uk-text-right"><span itemprop="seller"><?= Trl::_('OV_SITE_SHORT_NAME') ?> <time itemprop="datePublished" datetime="<?= $v['schema_time'] ?>"></time><?= $v['status'] ?><?= $v['edit_link'] ?></span></p>
            <h1 itemprop="headline" class="uk-text-center uk-margin-large-bottom"><?= $v['heading'] ?></h1>
            <p class="uk-text-center"><img src="<?= ItemImg::getItemImgPath($v['created'], $v['id'], $v['intro_img']) ?>" alt="" class="intro-image"></p>
            <article itemprop="articleBody" class="uk-margin-medium-top">
                <?= $v['intro_text'] ?>
                <?= $v['text'] ?>
                <?= $v['publisher'] ?>
            </article>
        </div>
    </div>
</div>
<?= Gallery::getI()->getGalleryHtml() ?>
<?= Content::getContentEnd() ?>
