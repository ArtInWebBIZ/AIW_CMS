<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Name\UserGroup as Ugn;
use Core\Plugins\Name\UserStatus as Usn;
use Core\Plugins\Ssl;

$edited      = $v['edited'] === $v['created'] ? '-' : userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']);
$editedCount = $v['edited_count'] == 0 ? '-' : '<a href="' . Ssl::getLinkLang() . 'user/edit-history/?edited_id=' . $v['id'] . '">' . $v['edited_count'] . '</a>';

?>
<tr>
    <td class="uk-text-center">
        <a href="<?= Ssl::getLinkLang() ?>user/<?= $v['id'] ?>.html"><?= $v['id'] ?></a>
    </td>
    <td class="uk-text-center"><?= Ugn::getGroupName($v['group']) ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></td>
    <td class="uk-text-center"><?= $edited ?></td>
    <td class="uk-text-center"><?= $editedCount ?></td>
    <td class="uk-text-center"><?= Usn::getColor($v['status']) ?></td>
</tr>
