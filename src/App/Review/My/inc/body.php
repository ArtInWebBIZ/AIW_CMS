<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, GV, BaseUrl};
use Comp\Review\Lib\Name\Status;

$edited = $v['edited'] == $v['created'] ? '' :
    '<div class="uk-text-center">
        ' . userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) . '
    </div>';
?>
<tr>
    <td class="uk-text-right">
        <a href="<?= BaseUrl::getLangToLink() ?>review/my/<?= GV::addToGet(['id' => $v['id']]) ?>"><?= $v['id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a href="<?= BaseUrl::getLangToLink() ?>review/<?= $v['id'] ?>.html" class="uk-text-primary" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-right">
        <a href="<?= BaseUrl::getLangToLink() ?>review/my/<?= GV::addToGet(['author_id' => $v['author_id']]) ?>"><?= $v['author_id'] ?></a>
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
