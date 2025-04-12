<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Content;
use Core\Modules\Pagination\Pagination;
use Core\Plugins\View\{Style, Tpl};

$body = $v['body'] == '' ? Tpl::view(PATH_INC . 'content' . DS . 'noResult.php') : $v['body'];

?>
<?= Content::getContentStart(Style::content()['section_css'], Style::content()['container_css'], Style::content()['overflow_css']) ?>
<div uk-grid>
    <?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
    <?= $body ?>
    <?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
</div>
<?= Content::getContentEnd() ?>
