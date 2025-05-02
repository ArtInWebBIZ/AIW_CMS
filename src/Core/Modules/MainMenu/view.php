<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Create\Menu\Menu;
use Core\{Trl, Auth, Router};
use Core\Plugins\Check\GroupAccess;

$uk_accordion = 'uk-accordion-content uk-margin-remove-top uk-margin-small-bottom';
?>
<a href="#main-menu" uk-icon="icon: menu; ratio: 2" class="menu-icon main c-grey" uk-toggle></a>
<div id="main-menu" uk-offcanvas="flip: false; overlay: true">
    <div class="uk-offcanvas-bar">
        <img src="/img/logo-h80px.png" alt="<?= Trl::_('OV_SITE_NAME') ?>">
        <?= Menu::getI()->createMenu(require PATH_INC . 'menu' . DS . 'mainMenu.php') ?>
        <?php if (Auth::getUserStatus() == 1) { ?>
            <ul uk-accordion>
                <li <?= Router::getRoute()['controller_url'] == 'review' ? 'class="uk-open"' : ''; ?>>
                    <a class="uk-accordion-title" href="#">
                        <img src="/img/icons-menu/notebook-and-pen.svg" width="18px" height="18px" alt=""> <?= Trl::_('REVIEW_REVIEWS') ?>
                    </a>
                    <div class="<?= $uk_accordion ?>">
                        <?= Menu::getI()->createAdminMenu(require PATH_INC . 'menu' . DS . 'adminReview.php') ?>
                    </div>
                </li>
                <?php if (GroupAccess::check([5])) { ?>
                    <li <?= Router::getRoute()['controller_url'] == 'blog' ? 'class="uk-open"' : ''; ?>>
                        <a class="uk-accordion-title" href="#">
                            <img src="/img/icons-menu/book-open.svg" width="18px" height="18px" alt=""> <?= Trl::_('BLOG_BLOG') ?>
                        </a>
                        <div class="<?= $uk_accordion ?>">
                            <?= Menu::getI()->createAdminMenu(require PATH_INC . 'menu' . DS . 'adminBlog.php') ?>
                        </div>
                    </li>
                <? } ?>
                <li <?= Router::getRoute()['controller_url'] == 'ticket' ? 'class="uk-open"' : ''; ?>>
                    <a class="uk-accordion-title" href="#"><img src="/img/icons-menu/editor.svg" width="18px" height="18px" alt=""> <?= Trl::_('TICKET_TICKETS') ?></a>
                    <div class="<?= $uk_accordion ?>">
                        <?= Menu::getI()->createAdminMenu(require PATH_INC . 'menu' . DS . 'adminTicket.php') ?>
                    </div>
                </li>
                <?php if (GroupAccess::check([5])) { ?>
                    <li <?= Router::getRoute()['controller_url'] == 'user' ? 'class="uk-open"' : ''; ?>>
                        <a class="uk-accordion-title" href="#">
                            <img src="/img/icons-menu/public.svg" width="18px" height="18px" alt=""> <?= Trl::_('USER_USERS') ?>
                        </a>
                        <div class="<?= $uk_accordion ?>">
                            <?= Menu::getI()->createAdminMenu(require PATH_INC . 'menu' . DS . 'adminUser.php') ?>
                        </div>
                    </li>
                <? } ?>
                <?php if (GroupAccess::check([5])) { ?>
                    <li <?= Router::getRoute()['controller_url'] == 'config-control' ? 'class="uk-open"' : ''; ?>>
                        <a class="uk-accordion-title" href="#"><img src="/img/icons-menu/setting-two.svg" width="18px" height="18px" alt=""> <?= Trl::_('CONFIG_PARAMETERS') ?></a>
                        <div class="<?= $uk_accordion ?>">
                            <?= Menu::getI()->createAdminMenu(require PATH_INC . 'menu' . DS . 'adminConfig.php') ?>
                        </div>
                    </li>
                <? } ?>
                <?php if (GroupAccess::check([5])) { ?>
                    <li <?= Router::getRoute()['controller_url'] == 'view-log' || Router::getRoute()['controller_url'] == 'item-controller' || Router::getRoute()['controller_url'] == 'search-bots-ip' ? 'class="uk-open"' : ''; ?>>
                        <a class="uk-accordion-title" href="#"><img src="/img/icons-menu/setting-config.svg" width="18px" height="18px" alt=""> <?= Trl::_('OV_CONTROL') ?></a>
                        <div class="<?= $uk_accordion ?>">
                            <?= Menu::getI()->createAdminMenu(require PATH_INC . 'menu' . DS . 'adminControl.php') ?>
                        </div>
                    </li>
                <? } ?>
            </ul>
        <? } ?>
    </div>
</div>
