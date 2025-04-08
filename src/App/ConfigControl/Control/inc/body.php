<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, BaseUrl, Trl};
use Core\Plugins\Check\GroupAccess;

$groupAccess = GroupAccess::check([5]) ? '<td class="uk-text-center">' . $v['group_access'] . '</td>' : '';

$edited = $v['edited'] == 0 ? '' :
    '
<div class="uk-flex uk-flex-between uk-flex-middle">
    <div>' . userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) . '</div>
    <div>
        <a href="' . BaseUrl::getLangToLink() . 'config-control/edit-history/?edited_id=' . $v['id'] . '" class="uk-text-primary" uk-icon="icon: history"></a>
    </div>
</div>';

?>
<tr>
    <td class="uk-text-right"><?= $v['id'] ?></td>
    <td class="uk-text-left w20px">
        <a href="<?= BaseUrl::getLangToLink() ?>config-control/edit/<?= $v['id'] ?>.html" class="uk-text-primary" uk-icon="icon: settings"></a>
    </td>
    <td class="uk-text-right"><?= Trl::_($v['params_name']) ?></td>
    <td class="uk-text-left"><?= $v['params_name'] ?></td>
    <td class="uk-text-center"><?= $v['params_value'] ?></td>
    <td class="uk-text-center"><?= $v['value_type'] ?></td>
    <?= $groupAccess ?>
    <td class="uk-text-center"><?= $edited ?></td>
</tr>
