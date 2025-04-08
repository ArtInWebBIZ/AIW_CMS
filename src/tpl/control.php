<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
use Core\Modules\Pagination\Pagination;
use Core\Plugins\View\Style;

// PATH_TPL . 'control.php'

?>
<?= Content::getContentStart(Style::control()['section_css'], Style::control()['container_css'], Style::control()['overflow_css']) ?>
<h1 class="<?= Style::control()['h1_css'] ?>"><?= Trl::_($v['title']) ?></h1>
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
