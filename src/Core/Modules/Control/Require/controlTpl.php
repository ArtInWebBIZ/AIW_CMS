<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
use Core\Modules\Pagination\Pagination;

?>
<?= Content::getContentStart($v['section_css'], $v['container_css'],) ?>
<h1 class="uk-text-center uk-margin-large-top<?= $v['item_heading'] != '' ? ' uk-margin-medium-bottom' : '' ?>"><?= Trl::_($v['title']) ?></h1>
<?php if ($v['item_heading'] != '') { ?>
    <h2 class="uk-text-center uk-margin-medium-bottom"><?= Trl::_($v['item_heading']) ?></h2>
<?php } ?>
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
