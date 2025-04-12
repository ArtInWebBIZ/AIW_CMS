<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{BaseUrl, Session, Trl};

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow, noarchive">
    <title>site under reconstruction</title>
    <link rel="stylesheet" href="/css/uikit.min.css">
    <link rel="stylesheet" href="/css/style.min.css">
    <script src="/js/uikit.min.js"></script>
    <script src="/js/uikit-icons.min.js"></script>
    <style>
        body {
            background: url(/img/bg/sai-kiran-anagani.jpg);
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <a href="#user-menu" uk-icon="icon: user; ratio: 2.5" class="menu-icon user" uk-toggle></a>
    <div id="user-menu" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar">
            <form action="<?= BaseUrl::getLangToLink() ?>user/login/" method="post" class="uk-margin-top">
                <label for="login_email"><?= Trl::_('USER_EMAIL') ?></label>
                <input type="email" name="login_email" required id="login_email" class="uk-input uk-margin-bottom">
                <label for="login_password"><?= Trl::_('USER_PASSWORD') ?></label>
                <input type="password" name="login_password" required id="login_password" class="uk-input">
                <input type="hidden" name="token" value="<?= Session::getToken() ?>">
                <button type="submit" class="uk-button uk-button-primary uk-align-center"><?= Trl::_('USER_LOGIN') ?></button>
            </form>
        </div>
    </div>
    <section class="uk-section uk-padding-remove uk-flex uk-flex-column uk-flex-between vh100">
        <div></div>
        <div class="uk-container uk-container-large">
            <h2 class="uk-heading-medium uk-text-center color-orange uk-text-bold uk-margin-remove text-shadow-white">Sorry :(<br>site under reconstruction</h2>
        </div>
        <p class="uk-background-muted uk-text-center">Photo by <a href="https://unsplash.com/@anagani_saikiran?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Sai Kiran Anagani</a> on <a href="https://unsplash.com/photos/5Ntkpxqt54Y?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a></p>
    </section>
</body>

</html>
