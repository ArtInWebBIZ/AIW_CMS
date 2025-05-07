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

?>
<?= Content::getContentStart('uk-padding-remove uk-margin-large-bottom', 'uk-container-xlarge uk-background-default') ?>
<h1 class="uk-text-center uk-margin-medium-top uk-margin-bottom"><?= Trl::_($v['title']) ?></h1>
<div class="uk-text-center uk-margin-small-top">
    <a href="/search-bots-ip/add/" class="uk-button uk-button-default"><?= Trl::_('SBIP_ADD') ?></a>
</div>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<table class="uk-table uk-table-small uk-table-middle uk-table-striped">
    <?= $v['control_header'] ?>
    <?= $v['control_body'] ?>
</table>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<?= Content::getContentEnd() ?>
