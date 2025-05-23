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
use App\Review\Add\Req\Func;
use Core\Plugins\View\Style;

?>
<?= Content::getContentStart(Style::content()['section_css'], Style::content()['container_css'], Style::content()['overflow_css']) ?>
<div class="uk-text-center uk-margin-large-bottom" uk-sticky="position: top">
    <?php if (Func::getI()->checkAccess()) { ?>
        <a class="uk-button uk-button-default uk-button uk-width-1-1 uk-margin-auto bg-green" href="/review/add/" uk-toggle><?= Trl::_('REVIEW_ADD') ?></a>
    <?php } else { ?>
        <a class="uk-button uk-button-default uk-button uk-width-1-1 uk-margin-auto bg-green" href="/user/login/" uk-toggle><?= Trl::_('REVIEW_ADD') ?></a>
    <?php } ?>
</div>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<?= $v['control_body'] ?>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<?= Content::getContentEnd() ?>
