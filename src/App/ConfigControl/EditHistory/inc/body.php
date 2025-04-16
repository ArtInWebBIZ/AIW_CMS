<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Config, GV, BaseUrl, Router};

$editorColor = $v['editor_id'] == Auth::getUserId() ? 'class="uk-text-muted" ' : '';

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-right">
        <a href="<?= BaseUrl::getLangToLink() . Router::getRoute()['controller_url'] ?>/edit-history/<?= GV::addToGet(['edited_id' => $v['edited_id']]) ?>"><?= $v['edited_id'] ?></a>
    </td>
    <td class="uk-text-left">
        <a href="<?= BaseUrl::getLangToLink() . Router::getRoute()['controller_url'] ?>/control/?id=<?= $v['edited_id'] ?>" class="uk-text-primary" uk-icon="icon: link"></a>
    </td>
    <td class="uk-text-right">
        <a <?= $editorColor ?>href="<?= BaseUrl::getLangToLink() . Router::getRoute()['controller_url'] ?>/edit-history/<?= GV::addToGet(['editor_id' => $v['editor_id']]) ?>"><?= $v['editor_id'] ?></a>
    </td>
    <td class="uk-text-left"><a href="<?= BaseUrl::getLangToLink() ?>user/<?= $v['editor_id'] ?>.html" class="uk-text-primary" uk-icon="icon: link"></a></td>
    <td class="uk-text-center"><?= $v['edited_params'] ?></td>
    <td class="uk-text-center"><?= $v['old_value'] ?></td>
    <td class="uk-text-center"><?= $v['new_value'] ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) ?></td>
</tr>
