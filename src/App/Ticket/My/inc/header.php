<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;

?>
<tr>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('TICKET_ID') ?></td>
    <td class="uk-text-center uk-text-bold" colspan="2"><?= Trl::_('TICKET_RESPONSIBLE_ID') ?></td>
    <td class="uk-text-center uk-text-bold" colspan="2"><?= Trl::_('LABEL_EDITOR_ID') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_CREATED') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('OV_EDITED_DATE') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('TICKET_STATUS') ?></td>
</tr>
