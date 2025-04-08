<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\Content;
use Core\GV;
use Core\Session;
use Core\Trl;

?>
<?= Content::getContentStart('content-section') ?>
<h1 class="uk-text-center"><?= Trl::_('TICKET_NUMBER') ?> #<?= $v['ticket_id'] ?></h1>
<div class="uk-grid">
    <div class="uk-width-1-1">
        <table class="uk-table uk-table-middle uk-table-small uk-table-striped">
            <tr>
                <td class="uk-text-right"><em><?= Trl::_('LABEL_AUTHOR') ?></em></td>
                <td>
                    <div class="uk-flex uk-flex-between">
                        <div><strong><?= $v['author_name'] ?></strong></div>
                        <div><a href="/<?= Session::getLang() . '/user/' . $v['author_id'] ?>.html" class="uk-text-primary" uk-icon="icon: link"></a></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="uk-text-right"><em><?= Trl::_('TICKET_TYPE') ?></em></td>
                <td><strong><?= $v['ticket_type'] ?></strong></td>
            </tr>
            <tr>
                <td class="uk-text-right"><em><?= Trl::_('TICKET_STATUS') ?></em></td>
                <td><strong><?= $v['ticket_status'] ?></strong></td>
            </tr>
            <?php if ($v['ticket_responsible'] > 0) { ?>
                <tr>
                    <td class="uk-text-right"><em><?= Trl::_('TICKET_RESPONSIBLE_ID') ?></em></td>
                    <td><span class="uk-text-small uk-text-muted">(User ID)</span>&nbsp;–&nbsp;<strong><?= $v['ticket_responsible'] ?></strong></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="uk-text-right"><em><?= Trl::_('LABEL_CREATED') ?></em></td>
                <td><strong><?= $v['ticket_created'] ?></strong></td>
            </tr>
            <?php if ($v['ticket_edited'] != '') { ?>
                <tr>
                    <td class="uk-text-right"><em><?= Trl::_('LABEL_EDITED') ?></em></td>
                    <td>
                        <div class="uk-flex uk-flex-between">
                            <div><strong><?= $v['ticket_edited'] ?></strong></div>
                            <div>
                                <a href="/<?= Session::getLang() . '/ticket/edit-history/' . GV::addToGet(['ticket_id' => $v['ticket_id']]) ?>" class="uk-text-primary" uk-icon="icon: history"></a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($v['ticket_editor_id'] != '') { ?>
                <tr>
                    <td class="uk-text-right"><em><?= Trl::_('LABEL_EDITOR_ID') ?></em></td>
                    <td><strong><?= $v['ticket_editor_id'] ?></strong></td>
                </tr>
            <?php } ?>
            <?php if ($v['ticket_confirm_code'] != '') { ?>
                <tr>
                    <td class="uk-text-right"><em><?= Trl::_('TICKET_CONFIRM_CODE') ?></em></td>
                    <td><strong><?= $v['ticket_confirm_code'] ?></strong></td>
                </tr>
            <?php } ?>
            <?php if ($v['users_balance'] != '') { ?>
                <tr>
                    <td class="uk-text-right"><em><?= Trl::_('USER_BALANCE') ?></em></td>
                    <td><strong><?= $v['users_balance'] ?></strong> <span class="uk-text-muted"><?= Config::getCfg('CFG_CURRENCY_SHORT_NAME') ?></span></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2">
                    <div class="uk-card uk-card-default uk-card-body uk-width-1-1 grey-border">
                        <?= $v['ticket_text'] ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="uk-width-1-1 uk-margin-small-top">
        <ul uk-accordion>
            <?php if ($v['answer_form'] != '') { ?>
                <li class="uk-open">
                    <a class="uk-accordion-title uk-alert-success" href="#"><?= Trl::_('TICKET_ANSWER_FORM') ?></a>
                    <div class="uk-accordion-content">
                        <?= $v['answer_form'] ?>
                    </div>
                </li>
            <?php } ?>
            <?php if ($v['bring_to_card_form'] != '') { ?>
                <li>
                    <a class="uk-accordion-title uk-alert-primary" href="#"><?= Trl::_('TICKET_BRING_TO_CARD') ?></a>
                    <div class="uk-accordion-content">
                        <?= $v['bring_to_card_form'] ?>
                    </div>
                </li>
            <?php } ?>
            <?php if ($v['ticket_change_status_form'] != '') { ?>
                <li>
                    <a class="uk-accordion-title uk-alert-primary" href="#"><?= Trl::_('TICKET_STATUS_CHANGE') ?></a>
                    <div class="uk-accordion-content">
                        <?= $v['ticket_change_status_form'] ?>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <?php if ($v['ticket_answers_list'] != '') { ?>
        <div class="uk-width-1-1 uk-margin-small-top">
            <?= $v['answers_pagination'] ?>
            <?= $v['ticket_answers_list'] ?>
            <?= $v['answers_pagination'] ?>
        </div>
    <?php } ?>
</div>
<?= Content::getContentEnd() ?>
