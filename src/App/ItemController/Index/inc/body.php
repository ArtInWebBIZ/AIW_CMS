<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Config};
use Core\Plugins\View\Name\NoYes;

?>
<tr>
    <td class="uk-text-right"><?= $v['id'] ?></td>
    <td class="uk-text-left"><a class="uk-text-primary" href="<?= BaseUrl::getLangToLink() ?>item-controller/edit/<?= $v['id'] ?>.html" uk-icon="icon: pencil"></a></td>
    <td class="uk-text-center"><?= $v['controller_url'] ?></td>
    <td class="uk-text-center"><?= NoYes::getColor($v['filters_table']) ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['created']) ?></td>
</tr>
