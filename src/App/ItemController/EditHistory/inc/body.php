<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, BaseUrl};
use App\ItemController\EditHistory\Req\Func;
use Core\Plugins\View\Name\NoYes;

if ($v['edited_field'] == 'filters_table') {
    $oldValue = NoYes::getColor($v['old_value']);
    $newValue = NoYes::getColor($v['new_value']);
} else {
    $oldValue = $v['old_value'];
    $newValue = $v['new_value'];
}

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-center"><a href="<?= BaseUrl::getLangToLink() ?>item-controller/"><?= $v['edited_id'] ?></a></td>
    <td class="uk-text-right"><?= $v['editor_id'] ?></td>
    <td class="uk-text-left"><a class="uk-text-primary" href="<?= BaseUrl::getLangToLink() ?>user/<?= $v['editor_id'] ?>.html" uk-icon="icon: link"></a></td>
    <td class="uk-text-center"><?= Func::getI()->fields()[$v['edited_field']]['label'] ?></td>
    <td class="uk-text-center"><?= $oldValue ?></td>
    <td class="uk-text-center"><?= $newValue ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) ?></td>
</tr>
