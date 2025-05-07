<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\BaseUrl;
use Core\GV;

defined('AIW_CMS') or die;

?>
<tr>
    <td class="uk-text-right"><a href="<?= GV::addToGet(['id' => $v['id']]) ?>"><?= $v['id'] ?></a></td>
    <td class="uk-text-left"><a class="uk-text-primary" href="<?= BaseUrl::getLangToLink() ?>search-bots-ip/edit/<?= $v['id'] ?>.html" uk-icon="icon: pencil"></a></td>
    <td class="uk-text-center"><?= long2ip($v['start_range']) ?></td>
    <td class="uk-text-center"><?= long2ip($v['end_range']) ?></td>
    <td class="uk-text-center"><?= $v['engine_name'] ?></td>
</tr>
