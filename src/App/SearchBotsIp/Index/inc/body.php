<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-center"><?= long2ip($v['start_range']) ?></td>
    <td class="uk-text-center"><?= long2ip($v['end_range']) ?></td>
    <td class="uk-text-center"><?= $v['engine_name'] ?></td>
</tr>
