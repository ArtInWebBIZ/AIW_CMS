<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Config, Trl};

?>
<div class="uk-card uk-card-body uk-padding-remove uk-margin-large-top">
    <div class="uk-flex uk-flex-between">
        <div>
            <a href="/review/<?= $v['id'] ?>.html"><span uk-icon="file-text"></span> - #<?= $v['id'] ?></a>
        </div>
        <div>
            <img src="/img/rating-stars-<?= $v['rating'] ?>.png" alt="">
        </div>
    </div>
    <div class="uk-flex uk-flex-between">
        <div>
            <a href="/user/<?= $v['author_id'] ?>.html"><span uk-icon="user"></span> - #<?= $v['author_id'] ?></a>
        </div>
        <div><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></div>
    </div>
    <p><?= $v['text'] ?></p>
    <p class="uk-text-right"><a href="<?= BaseUrl::getLangToLink() ?>review/<?= $v['id'] ?>.html" class="uk-icon-button" uk-icon="chevron-right"></a></p>
</div>
<hr class="uk-divider-icon">
