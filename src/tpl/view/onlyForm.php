<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, GV, Session, Trl, BaseUrl};
use Core\Plugins\Ssl;

require PATH_INC . 'formUk.php';

$httpReferrer = isset(GV::server()['HTTP_REFERER']) ? GV::server()['HTTP_REFERER'] : Ssl::getLinkLang();
$enctype      = $v['enctype'] === true ? ' enctype="multipart/form-data"' : '';

$cancel = $v['cancel_url'] !== null ? BaseUrl::getLangToLink() . $v['cancel_url'] : $httpReferrer;

if (isset($v['v_image']) && $v['v_image'] !== null) {
    $image = '
        <div class="uk-flex uk-flex-center">
            <img src="' . $v['v_image'] . '" alt="' . Trl::_($v['title']) . '" class="avatar">
        </div>';
} else {
    $image = '';
}

$containerCss      = isset($v['container_css']) ? $v['container_css'] : '';
$submitButtonStyle = isset($v['submit_button_style']) ? $v['submit_button_style'] : '';
$h                 = isset($v['h']) ? $v['h'] : 'h1';
$hMargin           = isset($v['h_margin']) ? $v['h_margin'] : 'uk-margin-large-bottom';
$buttonDivStyle    = isset($v['button_div_css']) ? $v['button_div_css'] : 'uk-margin-medium-top';
$buttonId          = isset($v['button_id']) ? 'id="' . $v['button_id'] . '" ' : '';
$include           = isset($v['include_after_form']) ? $v['include_after_form'] : '';

?>
<div class="<?= $containerCss ?>">
    <?php if ($v['title'] !== null) { ?>
        <<?= $h ?> class="uk-text-center color-title <?= $hMargin ?>"><?= Trl::_($v['title']) ?></<?= $h ?>>
    <?php } ?>
    <?= $image ?>
    <form onsubmit="document.body.classList.add('loaded_hiding'); document.body.classList.remove('loaded');" method="post" action="<?= BaseUrl::getLangToLink() ?><?= $v['url'] ?>" <?= ' ' . $enctype ?>>
        <?= (new Core\Modules\View\FormConstruct)->getFormConstruct($v['fields']) ?>
        <input type="hidden" name="token" value="<?= Session::getToken() ?>">
        <div class="uk-flex uk-flex-center <?= $buttonDivStyle ?>">
            <button <?= $buttonId ?>class="uk-button uk-button-primary <?= $submitButtonStyle ?>" type="submit"><?= Trl::_($v['button_label']) ?></button>
            <?php if ($v['cancel_url'] != 'hidden') { ?>
                <a href="<?= $cancel ?>" class="uk-button uk-button-default uk-margin-small-left"><?= Trl::_('OV_OUT') ?></a>
            <?php } ?>
        </div>
    </form>
    <?php if ($include != '') { ?>
        <div class="uk-flex uk-flex-center">
            <?= $v['include_after_form'] ?>
        </div>
    <?php } ?>
</div>
