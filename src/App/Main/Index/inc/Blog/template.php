<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Content, Trl};
use Core\Plugins\View\Style;

?>
<?php if ($v['body'] != '') { ?>
    <?= Content::getContentStart(
        Style::control()['section_css'] . ' uk-background-fixed uk-background-center-center',
        Style::control()['container_css'],
        Style::control()['overflow_css'],
        '',
        'background-image: url(/img/bg_02_ok.jpg);'
    ) ?>
    <h2 class="uk-text-center uk-margin-large-bottom uk-margin-large-top text-shadow-white"><?= Trl::_('BLOG_BLOG') ?></h2>
    <div class="uk-grid-divider uk-flex uk-flex-center" uk-grid>
        <?= $v['body'] ?>
    </div>
    <div class="uk-container uk-container-small uk-text-center uk-margin-large-top uk-margin-large-bottom">
        <strong><a href="<?= BaseUrl::getLangToLink() ?>blog/" class="uk-button uk-button-default uk-width-1-1 bg-green"><?= Trl::_('BLOG_BLOG') ?></a></strong>
    </div>
    <?= Content::getContentEnd() ?>
<? } ?>
