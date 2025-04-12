<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, GV, BaseUrl};
use Core\Plugins\Check\Item\AllItemFields;

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-right"><a href="<?= GV::addToGet(['item_id' => $v['item_id']]) ?>"><?= $v['item_id'] ?></a></td>
    <td class="uk-text-left"><a href="<?= BaseUrl::getLangToLink() ?>blog/<?= $v['item_id'] ?>.html" target="_blank" rel="noopener noreferrer" class="uk-text-primary" uk-icon="icon: link"></a></td>
    <td class="uk-text-right"><a href="<?= GV::addToGet(['editor_id' => $v['editor_id']]) ?>"><?= $v['editor_id'] ?></a></td>
    <td class="uk-text-left"><a href="<?= BaseUrl::getLangToLink() ?>user/<?= $v['editor_id'] ?>.html" class="uk-text-primary" uk-icon="icon: link"></a></td>
    <td class="uk-text-center"><?= AllItemFields::getAllItemFieldsName()[$v['edited_field']] ?></td>
    <td class="uk-text-center"><?= AllItemFields::getValueName($v['edited_field'], $v['old_value']) ?></td>
    <td class="uk-text-center"><?= AllItemFields::getValueName($v['edited_field'], $v['new_value']) ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_SECONDS_FORMAT'), $v['edited']) ?></td>
</tr>
