<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
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
<ul uk-accordion>
    <li>
        <a class="uk-accordion-title" href>
            <h3 class="uk-text-center uk-margin-remove"><?= Trl::_('ADMIN_COMPARE_LANG_FILES') ?></h3>
        </a>
        <div class="uk-accordion-content uk-flex uk-flex-center">
            <?= $v['form'] ?>
        </div>
    </li>
</ul>
<?php if ($v['file_name'] != '') { ?>
    <h3 class="uk-text-center uk-margin-medium-bottom"><?= $v['file_name'] ?></h3>
<? } ?>
<table class="uk-table uk-table-striped uk-table-middle">
    <?= $v['header'] ?>
    <?= $v['body'] ?>
</table>
<?= Content::getContentEnd() ?>
