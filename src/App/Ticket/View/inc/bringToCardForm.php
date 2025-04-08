<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Check\IntPageAlias;
use Core\{Session, Trl};

?>
<form action="/<?= Session::getLang() ?>/ticket/bring-to-card/" method="post">
    <input type="hidden" name="token" value="<?= Session::getToken() ?>">
    <input type="hidden" name="ticket_id" required="required" id="ticket_id" minlength="1" maxlength="12" value="<?= IntPageAlias::check() ?>">
    <table class="uk-table uk-table-small uk-table-striped uk-table-middle">
        <tr>
            <td class="uk-width-1-2">
                <input type="text" name="paid_sum" required="required" id="paid_sum" minlength="1" maxlength="12" class="uk-input">
            </td>
            <td>
                <button type="submit" class="uk-button uk-button-primary uk-width-1-1"><?= Trl::_('TICKET_BRING_TO_CARD') ?></button>
            </td>
        </tr>
    </table>
</form>
