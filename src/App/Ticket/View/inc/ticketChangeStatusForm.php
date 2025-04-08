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
<form action="/<?= Session::getLang() ?>/ticket/change-status/" method="post">
    <input type="hidden" name="token" value="<?= Session::getToken() ?>">
    <input type="hidden" name="id" value="<?= IntPageAlias::check() ?>">
    <table class="uk-table uk-table-small uk-table-striped uk-table-middle">
        <tr>
            <td class="uk-width-1-2">
                <?= $v['select'] ?>
            </td>
            <td>
                <button type="submit" class="uk-button uk-button-primary uk-width-1-1"><?= Trl::_('TICKET_STATUS_CHANGE') ?></button>
            </td>
        </tr>
    </table>
</form>
