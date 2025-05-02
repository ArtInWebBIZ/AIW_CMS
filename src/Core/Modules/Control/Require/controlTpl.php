<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
use Core\Modules\Pagination\Pagination;

$sectionCss   = isset($v['section_css']) ? $v['section_css'] : '';
$containerCss = isset($v['container_css']) ? $v['container_css'] : '';
$itemHeading  = isset($v['item_heading']) ? $v['item_heading'] : '';

?>
<?= Content::getContentStart($sectionCss, $containerCss,) ?>
<h1 class="uk-text-center uk-margin-large-top<?= $itemHeading != '' ? ' uk-margin-medium-bottom' : '' ?>"><?= Trl::_($v['title']) ?></h1>
<?php if ($itemHeading != '') { ?>
    <h2 class="uk-text-center uk-margin-medium-bottom"><?= Trl::_($itemHeading) ?></h2>
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
