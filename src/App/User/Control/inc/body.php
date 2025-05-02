<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\User\Lib\Name\{Group, Status};
use Core\Config;
use Core\Plugins\Ssl;

$edited      = $v['edited'] === $v['created'] ? '-' : userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']);
$editedCount = $v['edited_count'] == 0 ? '-' : '<a href="' . Ssl::getLinkLang() . 'user/edit-history/?edited_id=' . $v['id'] . '">' . $v['edited_count'] . '</a>';

?>
<tr>
    <td class="uk-text-center">
        <a href="<?= Ssl::getLinkLang() ?>user/<?= $v['id'] ?>.html"><?= $v['id'] ?></a>
    </td>
    <td class="uk-text-center"><?= Group::getGroupName($v['group']) ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></td>
    <td class="uk-text-center"><?= $edited ?></td>
    <td class="uk-text-center"><?= $editedCount ?></td>
    <td class="uk-text-center"><?= Status::getColor($v['status']) ?></td>
</tr>
