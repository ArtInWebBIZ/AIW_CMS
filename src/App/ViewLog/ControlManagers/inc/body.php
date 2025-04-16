<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, GV, Languages, BaseUrl};
use Core\Plugins\View\UrlFromId;

$userLink = $v['user_id'] > 0 ? '<a href="' . BaseUrl::getLangToLink() . 'user/' . $v['user_id'] . '.html" class="uk-text-primary" uk-icon="icon: link"></a>' : '';

if (count(Languages::langCodeList()) > 1) {
    $langLink = '
        <td class="uk-text-center">
            <a href="' . GV::addToGet(['lang' => $v['lang']]) . '">' . Languages::langCodeList()[$v['lang']] . '</a>
        </td>';
    $lang = '/' . Languages::langCodeList()[$v['lang']];
} else {
    $langLink = '';
    $lang = '';
}

$url = UrlFromId::url($v['url_id']) == '' ? '/' : '/' . UrlFromId::url($v['url_id']);

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <?= $langLink ?>
    <td class="uk-text-right">
        <a href="<?= $lang . $url ?>" target="_blank" rel="noopener noreferrer" class="uk-text-primary" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-left"><a href="<?= GV::addToGet(['url_id' => $v['url_id']]) ?>"><?= $url ?></a></td>
    <td class="uk-text-right"><a href="<?= GV::addToGet(['user_id' => $v['user_id']]) ?>"><?= $v['user_id'] ?></a></td>
    <td class="uk-text-left"><?= $userLink ?></td>
    <td class="uk-text-right"><a href="<?= GV::addToGet(['user_ip' => $v['user_ip']]) ?>"><?= long2ip($v['user_ip']) ?></a></td>
    <td class="uk-text-left">
        <a href="https://whatismyipaddress.com/ip/<?= long2ip($v['user_ip']) ?>" target="_blank" rel="noopener noreferrer" class="uk-text-primary" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-center"><?= $v['token'] ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_SECONDS_FORMAT'), $v['created']) ?></td>
</tr>
