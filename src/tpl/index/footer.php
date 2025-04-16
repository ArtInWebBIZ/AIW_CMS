<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;
use Core\Plugins\Ssl;
use Core\Plugins\View\Tpl;

?>
<footer class="uk-section">
    <div class="uk-container uk-container-large">
        <div class="uk-flex uk-flex-center uk-grid-divider" uk-grid>
            <?= Tpl::view(PATH_TPL . 'view' . DS . 'information.php') ?>
            <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-3@m uk-text-center">
                <h3><?= Trl::_('OV_COPYRIGHT') ?></h3>
                <table class="uk-table-middle uk-margin-auto">
                    <?= Tpl::view(PATH_TPL . 'view' . DS . 'copyright.php') ?>
                </table>
            </div>
            <?= Tpl::view(PATH_TPL . 'view' . DS . 'about.php') ?>
        </div>
    </div>
    <div class="uk-text-center uk-margin-medium-top">
        <span class="uk-text-small">©&nbsp;2024-<?= userDate("Y", time()) ?><br>©&nbsp;<?= Trl::_('OV_SITE_FULL_NAME') ?><br>© All rights reserved<br>Developed by <a href="https://artinweb.biz" target="_blank">ArtInWeb.biz</a></span><br><a href="<?= Ssl::getLink() ?>/sitemap.txt">sitemap.txt</a>
    </div>
</footer>
