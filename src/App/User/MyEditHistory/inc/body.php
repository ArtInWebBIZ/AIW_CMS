<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Config, GV, Trl, BaseUrl};
use Core\Plugins\Name\{UserGroup, UserStatus, UserEditFields};
use Core\Plugins\Name\User\Type;

$editorColor = $v['editor_id'] == Auth::getUserId() ? 'class="uk-text-muted" ' : '';

if ($v['edited_field'] == 'status') {
    $oldValue = UserStatus::getColor($v['old_value']);
    $newValue = UserStatus::getColor($v['new_value']);
} elseif ($v['edited_field'] == 'group') {
    $oldValue = UserGroup::getGroupName($v['old_value']);
    $newValue = UserGroup::getGroupName($v['new_value']);
} elseif ($v['edited_field'] == 'type') {
    $oldValue = Type::getColor($v['old_value']);
    $newValue = Type::getColor($v['new_value']);
} elseif ($v['edited_field'] == 'dep_num' && $v['old_value'] == 0) {
    $oldValue = '';
    $newValue = $v['new_value'];
} else {
    $oldValue = $v['old_value'];
    $newValue = $v['new_value'];
}

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-right">
        <a <?= $editorColor ?> href="<?= BaseUrl::getLangToLink() ?>user/my-edit-history/<?= GV::addToGet(['editor_id' => $v['editor_id']]) ?>"><?= $v['editor_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a class="uk-text-primary" href="<?= BaseUrl::getLangToLink() ?>user/<?= $v['editor_id'] ?>.html" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-center"><?= UserEditFields::getName($v['edited_field']) ?></td>
    <td class="uk-text-center"><?= $oldValue ?></td>
    <td class="uk-text-center"><?= $newValue ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) ?></td>
</tr>
