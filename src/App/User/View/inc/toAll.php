<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
use Core\Plugins\View\Style;

?>

<?= Content::getContentStart(Style::content()['section_css'], Style::content()['container_css'], Style::content()['overflow_css']) ?>
<div itemscope itemtype="https://schema.org/Person">
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
                            <strong><?= $v['userId'] ?></strong>
                        </td>
                    </tr>
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
                    <tr>
                        <td class="uk-text-right"><em><?= Trl::_('USER_REGISTRATION_DATE') ?></em></td>
                        <td class=""><strong><?= $v['userCreated'] ?></strong></td>
                    </tr>
                    <?php if (isset($v['latestVisit']) && $v['latestVisit'] != '') { ?>
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
