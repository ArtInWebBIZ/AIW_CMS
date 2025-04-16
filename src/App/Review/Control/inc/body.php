<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, GV, BaseUrl};
use Core\Plugins\Name\Review\Status;

$edited = $v['edited'] == $v['created'] ? '' :
    '<div class="uk-text-center">' . userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) . '</div>
    <div>
    &#160;&#160;<a href="' . BaseUrl::getLangToLink() . 'review/edit-history/?edited_id=' . $v['id'] . '" class="uk-text-primary" uk-icon="icon: history"></a>
    </div>';

?>
<tr>
    <td class="uk-text-right">
        <a href="<?= BaseUrl::getLangToLink() ?>review/control/<?= GV::addToGet(['id' => $v['id']]) ?>"><?= $v['id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a href="<?= BaseUrl::getLangToLink() ?>review/<?= $v['id'] ?>.html" class="uk-text-primary" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-right">
        <a href="<?= BaseUrl::getLangToLink() ?>review/control/<?= GV::addToGet(['author_id' => $v['author_id']]) ?>"><?= $v['author_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a href="<?= BaseUrl::getLangToLink() ?>user/<?= $v['author_id'] ?>.html" class="uk-text-primary" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-center">
        <img src="/img/rating-stars-<?= $v['rating'] ?>.png" alt="">
    </td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></td>
    <td class="uk-flex uk-flex-center uk-flex-middle"><?= $edited ?></td>
    <td class="uk-text-center"><?= Status::getColor($v['status']) ?></td>
</tr>
