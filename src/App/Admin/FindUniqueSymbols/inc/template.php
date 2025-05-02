<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Content;
use Core\Plugins\View\Style;

$style = Style::form();

?>
<?= Content::getContentStart($style['section_css'], $style['container_css'], $style['overflow_css']) ?>
<?= $v['header'] ?>
<hr>
<br><br>
<p class="uk-text-center"><?= $v['body'] ?></p>
<?= Content::getContentEnd() ?>
