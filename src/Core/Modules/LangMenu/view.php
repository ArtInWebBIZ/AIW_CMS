<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Modules\LangPageLinks;

?>
<a href="#lang-menu" uk-icon="icon: world; ratio: 2" class="menu-icon lang" uk-toggle></a>
<div id="lang-menu" uk-offcanvas="flip: true; overlay: true">
    <div class="uk-offcanvas-bar">
        <ul class="uk-list">
            <?= LangPageLinks::renderLinks() ?>
        </ul>
    </div>
</div>
