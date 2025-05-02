<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;

// ALL VALUES IS EXAMPLE  !!! CHANGE_THIS !!!

?>
<tr>
    <td class="uk-text-center"><?= $v['id'] ?></td>
    <td class="uk-text-center"><?= $v['author_id'] ?></td>
    <td class="uk-text-center"><?= $v['field_name'] ?></td>
    <td class="uk-text-center"><?= $v['old_value'] ?></td>
    <td class="uk-text-center"><?= $v['new_value'] ?></td>
    <td class="uk-text-center"><?= userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $v['edited']) ?></td>
</tr>
