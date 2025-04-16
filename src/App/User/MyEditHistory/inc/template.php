<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
use Core\Modules\Pagination\Pagination;
use Core\Plugins\View\Style;

?>
<?= Content::getContentStart(Style::control()['section_css'], Style::control()['container_css'], Style::control()['overflow_css']) ?>
<h1 class="<?= Style::control()['h1_css'] . ' uk-margin-remove-bottom' ?>"><?= Trl::_($v['title']) ?></h1>
<?php if ($v['item_heading'] != '') { ?>
    <h2 class="uk-text-center uk-margin-medium-bottom"><?= Trl::_($v['item_heading']) ?></h2>
<?php } ?>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<p class="uk-text-center"><?= Trl::sprintf('OV_RECEIVED_VALUES', ...[$v['count']]) ?></p>
<table class="uk-table uk-table-small uk-table-middle uk-table-striped">
    <?= $v['control_header'] ?>
    <?= $v['control_body'] ?>
</table>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<?= Content::getContentEnd() ?>
