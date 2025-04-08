<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Config, GV, BaseUrl};
use Core\Plugins\Name\{TicketEditFields, TicketStatus};

if ($v['edited_field'] == 'ticket_status') {
    $oldValue = TicketStatus::getColor($v['old_value']);
    $newValue = TicketStatus::getColor($v['new_value']);
} else {
    $oldValue = $v['old_value'];
    $newValue = $v['new_value'];
}

$editorIdColor = $v['editor_id'] == Auth::getUserId() ? 'class="uk-text-muted" ' : '';

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-right">
        <a href="<?= BaseUrl::getLangToLink() ?>ticket/edit-history/<?= GV::addToGet(['ticket_id' => $v['ticket_id']]) ?>"><?= $v['ticket_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a class="uk-text-primary" href="<?= BaseUrl::getLangToLink() ?>ticket/<?= $v['ticket_id'] ?>.html" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-right">
        <a <?= $editorIdColor ?> href="<?= BaseUrl::getLangToLink() ?>ticket/edit-history/<?= GV::addToGet(['editor_id' => $v['editor_id']]) ?>"><?= $v['editor_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a class="uk-text-primary" href="<?= BaseUrl::getLangToLink() ?>user/<?= $v['editor_id'] ?>.html" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-center"><?= TicketEditFields::getName($v['edited_field']) ?></td>
    <td class="uk-text-center"><?= $oldValue ?></td>
    <td class="uk-text-center"><?= $newValue ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) ?></td>
</tr>
