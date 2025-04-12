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
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_ID') ?></td>
    <td class="uk-text-center uk-text-bold" colspan="2"><?= Trl::_('USER_ID') ?></td>
    <td class="uk-text-center uk-text-bold" colspan="2"><?= Trl::_('LABEL_EDITOR_ID') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_PARAMETER') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_OLD_VALUE') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_NEW_VALUE') ?></td>
    <td class="uk-text-center uk-text-bold"><?= Trl::_('LABEL_EDITED') ?></td>
</tr>
