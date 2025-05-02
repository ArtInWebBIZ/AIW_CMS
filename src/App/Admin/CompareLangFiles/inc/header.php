<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\Trl;

defined('AIW_CMS') or die;

?>
<tr>
    <td class="uk-text-bold uk-text-right" style="width: 45%;"><?= $v['first_lang_label'] ?></td>
    <td class="uk-text-bold uk-text-center" style="width: 10%;"><?= Trl::_('OV_KEYS') ?></td>
    <td class="uk-text-bold uk-text-left" style="width: 45%;"><?= $v['second_lang_label'] ?></td>
</tr>
