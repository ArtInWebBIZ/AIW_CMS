<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Content, Trl};

?>
<?php if ($v['control_body'] != '') { ?>
    <h2 class="uk-text-center uk-margin-small-bottom uk-margin-large-top text-shadow-white"><?= Trl::_('REVIEW_REVIEWS') ?></h2>
    <?= Content::getContentStart('uk-padding', 'uk-container-xlarge uk-background-default uk-flex uk-flex-column uk-flex-center', '', 'review') ?>
    <div class="uk-child-width-1-1 uk-child-width-1-2@xl uk-flex uk-flex-center" uk-grid>
        <?= $v['control_body'] ?>
    </div>
    <div class="uk-container uk-container-small uk-text-center uk-margin-top uk-margin-medium-bottom">
        <strong><a href="<?= BaseUrl::getLangToLink() ?>review/" class="uk-button uk-button-default uk-width-1-1 bg-green"><?= Trl::_('REVIEW_ALL_REVIEWS') ?></a></strong>
    </div>
    <?= Content::getContentEnd() ?>
<?php } ?>
