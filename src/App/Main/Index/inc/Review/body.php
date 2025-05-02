<?php

defined('AIW_CMS') or die;

use Core\Config;

?>
<div>
    <div class="uk-card uk-card-body" uk-scrollspy="cls:uk-animation-fade; repeat: true">
        <div class="uk-flex uk-flex-between">
            <div>
                <a class="uk-text-primary" href="/review/<?= $v['id'] ?>.html"><span uk-icon="file-text"></span> - #<?= $v['id'] ?></a>
            </div>
            <div>
                <img src="/img/rating-stars-<?= $v['rating'] ?>.png" alt="">
            </div>
        </div>
        <div class="uk-flex uk-flex-between">
            <div>
                <a class="uk-text-primary" href="/user/<?= $v['author_id'] ?>.html"><span uk-icon="user"></span> - #<?= $v['author_id'] ?></a>
            </div>
            <div><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></div>
        </div>
        <p><?= $v['text'] ?></p>
    </div>
</div>
