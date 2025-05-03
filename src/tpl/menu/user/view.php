<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, BaseUrl, Session, Trl};
use Core\Plugins\Create\Menu\Menu;
use Core\Plugins\Ssl;

?>
<a href="#user-menu" uk-icon="icon: user; ratio: 2" class="menu-icon user" uk-toggle></a>
<div id="user-menu" uk-offcanvas="flip: true; overlay: true">
    <div class="uk-offcanvas-bar">
        <?php if (Auth::getUserId() == 0 && Session::getTmpStatus() == 0) { ?>
            <div class="uk-alert-warning" uk-alert>
                <p><?= Trl::_('USER_IN_MENU_ACTIVATE_PROFILE') ?></p>
            </div>
        <?php } ?>
        <?php if (Auth::getUserId() == 0) { ?>

            <form id="user_login" action="<?= BaseUrl::getLangToLink() ?>user/login/" method="post" class="uk-margin-top">
                <label for="login_email" class="uk-margin-small-left"><?= Trl::_('USER_EMAIL') ?></label>
                <input type="email" name="login_email" required id="login_email" class="uk-input input-shadow uk-margin-bottom">
                <label for="login_password" class="uk-margin-small-left"><?= Trl::_('USER_PASSWORD') ?></label>
                <input type="password" name="login_password" required id="login_password" class="uk-input input-shadow">
                <input type="hidden" name="token" value="<?= Session::getToken() ?>">
                <input type="hidden" name="referer" value="<?= Ssl::getLink() . BaseUrl::getBaseUrl() ?>">
                <button type="submit" class="uk-button uk-button-primary uk-align-center uk-width-1-2"><?= Trl::_('USER_LOGIN') ?></button>
            </form>

            <?= Menu::getI()->createMenu(require PATH_INC . 'menu' . DS . 'userGuest.php') ?>

        <?php } else { ?>

            <?php if (Auth::getUserAvatar() != '') { ?>
                <div class="uk-flex uk-flex-center">
                    <img src="<?= Auth::getUserAvatar() ?>" alt="<?= Auth::getUserFullName() ?>">
                </div>
            <? } ?>

            <?= Menu::getI()->createMenu(require PATH_INC . 'menu' . DS . 'userAuthorised.php') ?>

        <?php } ?>

    </div>
</div>
