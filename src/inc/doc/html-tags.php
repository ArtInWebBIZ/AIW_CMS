<?php

/**
 * @package    ArtInWebCMS.doc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;

$title     = Trl::_('DOC_HTML_TAGS');
$ukClass   = 'uk-list uk-column-1-1 uk-column-1-2@s uk-column-1-3@m uk-column-1-4@l uk-column-divider';
$ukH3Class = 'uk-text-center';

?>
<section class="uk-section">
    <div class="uk-container uk-container-small">
        <div class="uk-grid uk-flex uk-flex-center">
            <div class="uk-width-1-1">

                <h1 class="uk-text-center"><?= $title ?></h1>
                <h3 class="<?= $ukH3Class ?>">!</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;!DOCTYPE&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;!-- --&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">A</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: check"></span>&nbsp;&lt;a&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;abbr&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;acronym&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;address&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;applet&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;area&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;article&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;aside&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;audio&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">B</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;b&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;base&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;basefont&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;bdi&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;bdo&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;bgsound&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;blockquote&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;big&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;body&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;blink&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;br&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;button&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">C</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;canvas&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;caption&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;center&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;cite&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;code&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;col&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;colgroup&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;command&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;comment&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">D</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;datalist&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;dd&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;del&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;details&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;dfn&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;dir&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;div&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;dl&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;dt&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">E</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;em&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;embed&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">F</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;fieldset&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;figcaption&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;figure&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;font&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;form&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;footer&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;frame&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;frameset&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">H</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;h1&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;h2&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;h3&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;h4&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;h5&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;h6&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;head&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;header&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;hgroup&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;hr&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;html&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">I</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;i&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;iframe&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;img&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;input&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;ins&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;isindex&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">K</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;kbd&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;keygen&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">L</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;label&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;legend&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;li&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;link&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">M</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;main&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;map&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;marquee&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;mark&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;menu&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;meta&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;meter&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">N</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;nav&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;nobr&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;noembed&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;noframes&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;noscript&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">O</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;object&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;ol&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;optgroup&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;option&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;output&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">P</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;p&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;param&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;plaintext&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;pre&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;progress&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">Q</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;q&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">R</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;rp&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;rt&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;ruby&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">S</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;s&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;samp&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;script&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;section&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;select&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;small&gt;</li>
                    <li><span class="c-red" uk-icon="icon: check"></span>&nbsp;&lt;span&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;source&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;strike&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;strong&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;style&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;sub&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;summary&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;sup&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">T</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;table&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;tbody&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;td&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;textarea&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;tfoot&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;th&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;thead&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;time&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;title&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;tr&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;tt&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">U</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;u&gt;</li>
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;ul&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">V</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;var&gt;</li>
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;video&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">W</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-lime" uk-icon="icon: check"></span>&nbsp;&lt;wbr&gt;</li>
                </ul>

                <h3 class="<?= $ukH3Class ?>">X</h3>
                <ul class="<?= $ukClass ?>">
                    <li><span class="c-red" uk-icon="icon: close"></span>&nbsp;&lt;xmp&gt;</li>
                </ul>
            </div>
        </div>
    </div>
</section>
