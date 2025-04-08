<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Content, Trl};
use Core\Plugins\Ssl;
use Core\Plugins\View\Style;

?>
<?= Content::getContentStart(Style::content()['section_css'], Style::content()['container_css'], Style::content()['overflow_css']) ?>
<div class="uk-width-1-1" itemscope itemtype="https://schema.org/Person">
    <h1 class="<?= Style::content()['h1_css'] ?>" itemprop="name"><?= $v['userFullName'] ?></h1>
    <?php if ($v['avatar'] != '') { ?>
        <div class="uk-flex uk-flex-center uk-margin-medium-bottom">
            <img src="<?= $v['avatar'] ?>" alt="<?= $v['userFullName'] ?>" class="avatar">
        </div>
    <? } ?>
    <div class="uk-flex-middle" uk-grid>
        <div class="uk-width-expand">
            <table class="uk-table uk-table-middle uk-table-small uk-table-striped">
                <tbody>
                    <tr>
                        <td class="uk-text-right uk-width-1-2"><em><?= Trl::_('USER_ID') ?></em></td>
                        <td class="uk-width-1-2">
                            <div class="uk-flex uk-flex-between">
                                <div><strong><?= $v['userId'] ?></strong></div>
                                <div><?= $v['toEditedLink'] ?></div>
                            </div>
                        </td>
                    </tr>
                    <?php if ($v['userStatusName'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_STATUS') ?></em></td>
                            <td class=""><strong><?= $v['userStatusName'] ?></strong></td>
                        </tr>
                    <?php } ?>
                    <?php if ($v['userGroupName'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_GROUP') ?></em></td>
                            <td class=""><strong><?= $v['userGroupName'] ?></strong></td>
                        </tr>
                    <?php } ?>
                    <?php if (Auth::getUserGroup() == 5) { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_EMAIL') ?></em></td>
                            <td class=""><strong><?= $v['user_email'] ?></strong></td>
                        </tr>
                    <?php } ?>
                    <?php if ($v['user_phone'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_PHONE') ?></em></td>
                            <td class="">
                                <div class="uk-flex uk-flex-between">
                                    <div>
                                        <a title="Viber" href="viber://chat?number=+<?= $v['user_phone'] ?>"><strong>+<?= $v['user_phone'] ?></strong></a>
                                    </div>
                                    <?php if (Auth::getUserId() == $v['userId'] && $v['type'] == 0) { ?>
                                        <div>
                                            <a href="#user_phone-modal" uk-icon="icon: info" class="c-gold uk-icon" uk-toggle="" aria-expanded="false"></a>
                                            <div id="user_phone-modal" class="uk-flex-top uk-modal" uk-modal="">
                                                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                                                    <button class="uk-modal-close-default uk-icon uk-close" type="button" uk-close></button>
                                                    <p><?= Trl::_('INFO_USER_PHONE_ACCESS') ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <? } ?>
                    <?php if ($v['youtube'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_YOUTUBE') ?></em></td>
                            <td class=""><strong><a href="https://youtube.com/<?= $v['youtube'] ?>" target="_blank" rel="noopener noreferrer">https://youtube.com/<?= $v['youtube'] ?></a></strong></td>
                        </tr>
                    <? } ?>
                    <?php if ($v['website'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_WEBSITE') ?></em></td>
                            <td class=""><strong><a href="<?= $v['website'] ?>" target="_blank" rel="noopener noreferrer"><?= $v['website'] ?></a></strong></td>
                        </tr>
                    <? } ?>
                    <?php if ($v['soc_net_page'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_SOC_NET_PAGE') ?></em></td>
                            <td class=""><strong><a href="<?= $v['soc_net_page'] ?>" target="_blank" rel="noopener noreferrer"><?= $v['soc_net_page'] ?></a></strong></td>
                        </tr>
                    <? } ?>
                    <?php if ($v['balance'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_BALANCE') ?></em></td>
                            <td class=""><strong><?= $v['balance'] ?> $ <span class="uk-text-meta">(USD)</span></strong></td>
                        </tr>
                    <? } ?>
                    <tr>
                        <td class="uk-text-right"><em><?= Trl::_('USER_REGISTRATION_DATE') ?></em></td>
                        <td class=""><strong><?= $v['userCreated'] ?></strong></td>
                    </tr>
                    <?php if ($v['latestEdited'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_EDITED') ?></em></td>
                            <td class="">
                                <div class="uk-flex uk-flex-between">
                                    <div><strong><?= $v['latestEdited'] ?></strong></div>
                                    <div>
                                        <?php if ($v['userId'] != Auth::getUserId() && $v['userGroupName'] != '' && Auth::getUserGroup() > 2 && Auth::getUserStatus() == 1) { ?>
                                            <a href="<?= Ssl::getLinkLang() . 'user/edit-history/?edited_id=' . $v['userId'] ?>" class="uk-text-primary" uk-icon="icon: history"></a>
                                        <?php } elseif ($v['userId'] == Auth::getUserId() && $v['userGroupName'] != '') { ?>
                                            <a href="<?= Ssl::getLinkLang() ?>/user/my-edit-history/" class="uk-text-primary" uk-icon="icon: history"></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($v['latestVisit'] != '') { ?>
                        <tr>
                            <td class="uk-text-right"><em><?= Trl::_('USER_LATEST_VISIT') ?></em></td>
                            <td class=""><strong><?= $v['latestVisit'] ?></strong></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= Content::getContentEnd() ?>
