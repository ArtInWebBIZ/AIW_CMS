<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\GV;
use Core\Plugins\Name\Blog\Status;

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-right"><a href="<?= GV::addToGet(['author_id' => $v['author_id']]) ?>"><?= $v['author_id'] ?></a></td>
    <td class="uk-text-left uk-text-primary"><a href="/user/<?= $v['author_id'] ?>.html" uk-icon="icon: link"></a></td>
    <td class="uk-text-center"><a href="/blog/<?= $v['id'] ?>.html"><?= $v['heading'] ?></a></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) ?></td>
    <td class="uk-text-center"><?= Status::getColor($v['status']) ?></td>
</tr>
