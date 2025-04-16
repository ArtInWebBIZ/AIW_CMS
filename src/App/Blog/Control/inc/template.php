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
use Core\Plugins\Check\Item;

?>
<?= Content::getContentStart('uk-padding-remove', 'uk-container-xlarge uk-background-default uk-padding') ?>
<h1 class="uk-text-center uk-margin-large-top"><?= Trl::_(Item::getI()->itemParams()['title']) ?></h1>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<p class="uk-text-center"><?= Trl::sprintf('OV_RECEIVED_VALUES', ...[$v['count']]) ?></p>
<div class="uk-overflow-auto">
    <table class="uk-table uk-table-small uk-table-middle uk-table-striped">
        <?= $v['header'] ?>
        <?= $v['body'] ?>
    </table>
</div>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<?= Content::getContentEnd() ?>
