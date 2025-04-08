<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Trl};
use Core\Modules\LineMenu\LineMenu;

?>
<nav class="">
    <div class="uk-flex uk-flex-center uk-flex-middle nav-div">
        <div class="uk-margin-right">
            <a class="uk-navbar-item uk-logo" href="<?= BaseUrl::getLangToLink() ?>">
                <img src="/img/logo_h80.png" alt="">
            </a>
        </div>
        <?= LineMenu::getMenuView() ?>
    </div>
</nav>
