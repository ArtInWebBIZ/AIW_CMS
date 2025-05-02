<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Session, Trl};

require PATH_INC . 'formUk.php';

$fields = require $v['filter_fields'];

?>
<?php if (is_array($fields) && $fields !== []) { ?>
    <a href="#filters-form" uk-icon="icon: search; ratio: 2" class="menu-icon search" uk-toggle></a>
    <div id="filters-form" uk-offcanvas>
        <div class="uk-offcanvas-bar">
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <h3 class="uk-margin-large-top uk-text-center"><?= Trl::_($v['title']) ?></h3>
            <form action="<?= BaseUrl::getLangToLink() . $v['page_link'] ?>" method="post">
                <?= (new Core\Modules\View\FiltersConstruct)->getFormConstruct($fields) ?>
                <input type="hidden" name="token" value="<?= Session::getToken() ?>">
                <div class="filters-buttons-div uk-margin-medium-top">
                    <button type="submit" class="uk-button uk-button-primary"><?= Trl::_($v['filter_button_label']) ?></button>
                    <a href="<?= BaseUrl::getLangToLink() . $v['filters_clear_link'] ?>" class="uk-button uk-button-default"><?= Trl::_('INFO_CLEAR_FILTERS') ?></a>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
