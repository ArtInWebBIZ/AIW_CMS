<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Trl, Languages};

?>
<tr>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_ID') ?></td>
    <?php if (count(Languages::langCodeList()) > 1) { ?>
        <td class="uk-text-center uk-text-bold"><?= Trl::_('OV_LANG') ?></td>
    <? } ?>
    <td class="uk-text-center uk-text-bold" colspan="2"><?= Trl::_('LABEL_LINK') ?></td>
    <td class="uk-text-center uk-text-bold" colspan="2"><?= Trl::_('USER_ID') ?></td>
    <td class="uk-text-center uk-text-bold" colspan="2"><?= Trl::_('USER_IP') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('CONFIG_TOKEN') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('OV_VISITED') ?></td>
</tr>
