<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;

?>
<tr>
    <td class="uk-text-center uk-text-bold">ID</td>
    <td class="uk-text-center uk-text-bold" colspan="2"><?= Trl::_('LABEL_AUTHOR_ID') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('ITEM_HEADING') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_CREATED') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_EDITED') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('OV_STATUS') ?></td>
</tr>
