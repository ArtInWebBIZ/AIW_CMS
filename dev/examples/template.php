<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
use Core\Modules\Pagination\Pagination;
use Core\Plugins\View\Style;

$style = Style::control();

/**
 * !!! ATTENTION !!!
 * if enabled ['example_key'] in variable $v in this template,
 * KEY VARIABLE ['example_key'] IS REQUIRED TO INCLUDE ON THIS TEMPLATE !!!
 * elsewhere, return empty page
 */

?>
<?= Content::getContentStart($style['section_css'], $style['container_css'], $style['overflow_css']) ?>
<h1 class="<?= $style['h1_css'] ?>"><?= Trl::_($v['title']) ?></h1>
<?php if ($v['item_title'] != '') { ?>
    <h2 class="uk-text-center uk-margin-medium-bottom"><?= Trl::_($v['item_title']) ?></h2>
<? } ?>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<?= $v['control_header'] ?>
<?= $v['control_body'] ?>
<?= Pagination::getPagination($v['count'], $v['paginationStep']) ?>
<?= Content::getContentEnd() ?>
