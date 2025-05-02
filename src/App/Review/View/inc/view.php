<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Content, Config, Trl};
use Core\Plugins\Name\Review\Status;
use Core\Plugins\View\Style;

?>
<?= Content::getContentStart(Style::content()['section_css'], Style::content()['container_css'], Style::content()['overflow_css']) ?>
<h1 class="uk-text-center"><?= Trl::_('REVIEW_REVIEW') ?> #<?= $v['id'] ?></h1>
<div itemscope itemtype="http://schema.org/Review" class="uk-card uk-card-body">
    <div class="uk-flex uk-flex-between uk-flex-wrap">
        <div>
            <a href="/user/<?= $v['author_id'] ?>.html"><span itemprop="author"><span uk-icon="user"></span> - #<?= $v['author_id'] ?></span></a>
        </div>
        <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
            <img src="/img/rating-stars-<?= $v['rating'] ?>.png" alt="">
            <meta itemprop="worstRating" content="0">
            <span itemprop="ratingValue" class="uk-hidden"><?= $v['rating'] ?></span>
            <span itemprop="bestRating" class="uk-hidden">5</span>
        </div>
        <time itemprop="datePublished" datetime="<?= userDate(Config::getCfg('CFG_SCHEMA_TIME_FORMAT'), $v['created']) ?>"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></time>
        <?php if ($v['status'] != '' || $v['edit_access'] != '') { ?>
            <div>
                <?php if ($v['status'] != '') { ?>
                    <?= Status::getColor($v['status']) ?>
                <?php } ?>
                <?php if ($v['edit_access'] != '') { ?>
                    / <a href="<?= BaseUrl::getLangToLink() ?>review/edit/<?= $v['id'] ?>.html"><?= Trl::_('OV_EDIT') ?></a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <p itemprop="reviewBody"><?= $v['text'] ?></p>
</div>
<?= Content::getContentEnd() ?>
