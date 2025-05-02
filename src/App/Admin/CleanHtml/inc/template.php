<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Trl};
use Core\Plugins\View\Style;

$style = Style::content();

?>
<?= Content::getContentStart($style['section_css'], $style['container_css'], $style['overflow_css']) ?>
<ul uk-accordion>
    <li>
        <a class="uk-accordion-title" href>
            <h3 class="uk-text-center uk-margin-remove"><?= Trl::_('ADMIN_CLEAN_HTML') ?></h3>
        </a>
        <div class="uk-accordion-content">
            <?= $v['form'] ?>
        </div>
    </li>
</ul>
<hr><br><br><br>
<?= $v['body'] ?>
<?= Content::getContentEnd() ?>
