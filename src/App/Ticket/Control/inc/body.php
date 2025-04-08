<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Config, GV, BaseUrl};
use Core\Plugins\Name\TicketStatus;

if ($v['responsible'] == Auth::getUserId()) {
    $responsibleColor = ' class="uk-text-muted"';
} else {
    $responsibleColor = '';
}

if ($v['responsible'] == 0) {
    $responsible = '-';
} else {
    $responsible = '<a' . $responsibleColor . ' href="' . BaseUrl::getLangToLink() . 'ticket/control/' . GV::addToGet(['responsible' => $v['responsible']]) . '">' . $v['responsible'] . '</a>';
}

if (Auth::getUserGroup() > 2 && $v['responsible'] != 0) {
    $responsibleLink = '<a href="' . BaseUrl::getLangToLink() . 'user/' . $v['responsible'] . '.html" class="uk-text-primary" uk-icon="icon: link"></a>';
} else {
    $responsibleLink = '';
}

if (
    $v['editor_id'] == Auth::getUserId() &&
    $v['editor_id'] == $v['responsible']
) {

    $editorIdColor = ' class="uk-text-muted"';
} elseif (
    ($v['editor_id'] == Auth::getUserId() &&
        $v['editor_id'] != $v['responsible']
    ) ||
    ($v['editor_id'] != $v['responsible'] &&
        Auth::getUserGroup() > 2
    )
) {

    $editorIdColor = ' class="uk-text-danger"';
} else {

    $editorIdColor = '';
}

if ($v['editor_id'] == 0) {
    $editorId = '-';
} else {
    $editorId = '<a' . $editorIdColor . ' href="' . BaseUrl::getLangToLink() . 'ticket/control/' . GV::addToGet(['editor_id' => $v['editor_id']]) . '">' . $v['editor_id'] . '</a>';
}

if (Auth::getUserGroup() > 2 && $v['editor_id'] != 0) {
    $editorLink = '<a href="' . BaseUrl::getLangToLink() . 'user/' . $v['responsible'] . '.html" class="uk-text-primary" uk-icon="icon: link"></a>';
} elseif ($v['responsible'] == 0) {
    $editorLink = '';
} else {
    $editorLink = '';
}

$edited = $v['edited'] === $v['created'] ? '-' : userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']);

?>
<tr>
    <td class="uk-text-center">
        <a href="<?= BaseUrl::getLangToLink() ?>ticket/<?= $v['id'] ?>.html"><?= $v['id'] ?></a>
    </td>
    <td class="uk-text-right"><?= $responsible ?></td>
    <td class="uk-text-left"><?= $responsibleLink ?></td>
    <td class="uk-text-right"><?= $editorId ?></td>
    <td class="uk-text-left"><?= $editorLink ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></td>
    <td class="uk-text-center"><?= $edited ?></td>
    <td class="uk-text-center"><?= TicketStatus::getColor($v['ticket_status']) ?></td>
</tr>
