<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;
use Core\Plugins\Check\GroupAccess;

?>
<tr>
    <td class="uk-text-center uk-text-bold" colspan="2">ID</td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('CONFIG_DESCRIPTIONS') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('CONFIG_PARAMETER') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('CONFIG_PARAMETER_VALUE') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('CONFIG_VALUE_TYPE') ?></td>
    <?php if (GroupAccess::check([5])) { ?>
        <td class="uk-text-center uk-text-bold"><?= Trl::_('CONFIG_GROUP_ACCESS') ?></td>
    <?php } ?>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('OV_EDITED_DATE') ?></td>
</tr>
