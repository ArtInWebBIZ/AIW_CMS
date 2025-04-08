<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, BaseUrl, Config, GV};
use Core\Plugins\Name\Review\{Fields, Status};

if ($v['editor_id'] == Auth::getUserId()) {
    $editorColor = 'class="uk-text-muted" ';
} elseif ($v['edited_id'] != $v['editor_id']) {
    $editorColor = 'class="uk-text-danger" ';
} else {
    $editorColor = '';
}

if ($v['edited_field'] == 'status') {
    $oldValue = Status::getColor($v['old_value']);
    $newValue = Status::getColor($v['new_value']);
} else {
    $oldValue = $v['old_value'];
    $newValue = $v['new_value'];
}

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-right">
        <a href="<?= BaseUrl::getLangToLink() ?>review/edit-history/<?= GV::addToGet(['edited_id' => $v['edited_id']]) ?>"><?= $v['edited_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a class="uk-text-primary" href="<?= BaseUrl::getLangToLink() ?>review/<?= $v['edited_id'] ?>.html" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-right">
        <a <?= $editorColor ?>href="<?= BaseUrl::getLangToLink() ?>review/edit-history/<?= GV::addToGet(['editor_id' => $v['editor_id']]) ?>"><?= $v['editor_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a class="uk-text-primary" href="<?= BaseUrl::getLangToLink() ?>user/<?= $v['editor_id'] ?>.html" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-center"><?= Fields::getName($v['edited_field']) ?></td>
    <td class="uk-text-center"><?= $oldValue ?></td>
    <td class="uk-text-center"><?= $newValue ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) ?></td>
</tr>
