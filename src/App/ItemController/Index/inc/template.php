<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Content, Trl};
use Core\Modules\Pagination\Pagination;

?>
<?= Content::getFormStart($v['section_css']) ?>
<h1 class="uk-text-center uk-margin-large-top"><?= Trl::_($v['title']) ?></h1>
<div class="uk-text-center">
    <a href="<?= BaseUrl::getLangToLink() ?>item-controller/add/" class="uk-button uk-button-default"><?= Trl::_('ITEM_CONTROLLER_URL_ADD') ?></a>
</div>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<p class="uk-text-center"><?= Trl::sprintf('OV_RECEIVED_VALUES', ...[$v['count']]) ?></p>
<div class="uk-overflow-auto">
    <table class="uk-table uk-table-small uk-table-middle uk-table-striped">
        <?= $v['control_header'] ?>
        <?= $v['control_body'] ?>
    </table>
</div>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<?= Content::getContentEnd() ?>
