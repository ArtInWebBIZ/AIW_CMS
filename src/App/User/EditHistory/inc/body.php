<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Config, GV};
use Core\Plugins\Name\UserEditFields;
use Core\Plugins\Name\{UserGroup, UserStatus};
use Core\Plugins\Ssl;

if ($v['edited_field'] == 'group') {
    $oldValue = UserGroup::getGroupName($v['old_value']);
    $newValue = UserGroup::getGroupName($v['new_value']);
} elseif ($v['edited_field'] == 'status') {
    $oldValue = UserStatus::getColor($v['old_value']);
    $newValue = UserStatus::getColor($v['new_value']);
} else {
    $oldValue = $v['old_value'];
    $newValue = $v['new_value'];
}

$editedColor = $v['edited_id'] == Auth::getUserId() ? ' class="uk-text-muted"' : '';

if ($v['editor_id'] == Auth::getUserId()) {
    $editorColor = 'class="uk-text-muted" ';
} elseif ($v['edited_id'] != $v['editor_id']) {
    $editorColor = 'class="uk-text-danger" ';
} else {
    $editorColor = '';
}

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-right">
        <a <?= $editedColor ?>href="<?= Ssl::getLinkLang() ?>user/edit-history/<?= GV::addToGet(['edited_id' => $v['edited_id']]) ?>"><?= $v['edited_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a class="uk-text-primary" href="<?= Ssl::getLinkLang() ?>user/<?= $v['edited_id'] ?>.html" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-right">
        <a <?= $editorColor ?>href="<?= Ssl::getLinkLang() ?>user/edit-history/<?= GV::addToGet(['editor_id' => $v['editor_id']]) ?>"><?= $v['editor_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a class="uk-text-primary" href="<?= Ssl::getLinkLang() ?>user/<?= $v['editor_id'] ?>.html" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-center"><?= UserEditFields::getName($v['edited_field']) ?></td>
    <td class="uk-text-center"><?= $oldValue ?></td>
    <td class="uk-text-center"><?= $newValue ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) ?></td>
</tr>
