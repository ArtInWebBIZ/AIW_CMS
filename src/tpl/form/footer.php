<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Trl};
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
                    <?= Tpl::view(PATH_TPL . 'form' . DS . 'background.php') ?>
                </table>
            </div>
            <?= Tpl::view(PATH_TPL . 'view' . DS . 'about.php') ?>
        </div>
    </div>
</footer>
