<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{App, BaseUrl, ErrorHandler as Errors, GV, Session, Trl, Languages};
use Core\Modules\Menu\{LangMenu, MainMenu, UserMenu};
use Core\Plugins\{Ssl, Check\TimeDifference};
use Core\Plugins\View\Tpl;

include PATH_TPL . DS . 'index' . DS . 'redirect.php';

$rtl = Session::getRtl() == 1 ? '-rtl' : '';
?>
<!DOCTYPE html>
<html lang="<?= Session::getLang() ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= Ssl::getLink() . BaseUrl::getBaseUrl() ?>">
    <title><?= Trl::_(App::content()['title']) ?> - <?= Trl::_('OV_SITE_NAME') ?></title>
    <?= Tpl::view(PATH_TPL . 'index' . DS . 'linkToFontsOLD.php') ?>
    <link rel="stylesheet" href="/css/uikit<?= $rtl ?>.min.css">
    <link rel="stylesheet" href="/css/style.min.css">
    <?= App::content()['toTopStyles'] = App::content()['toTopStyles'] != '' ? App::content()['toTopStyles'] : '' ?>
    <?= App::content()['toTopScript'] = App::content()['toTopScript'] != '' ? App::content()['toTopScript'] : '' ?>
</head>

<body>
    <?= Tpl::view(PATH_TPL . 'index' . DS . 'preloader.php') ?>
    <a href="#top" uk-totop uk-list uk-scroll></a>
    <?php if (isset(Errors::getI()->getErrors()['error'])) { ?>
        <section class="uk-section uk-section-xsmall">
            <div class="uk-container uk-container-small">
                <div class="uk-grid uk-flex uk-flex-center">
                    <div class="uk-width-1-1">
                        <?= Errors::getI()->getErrors()['error'] ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?= UserMenu::getMenuView() ?>
    <?= LangMenu::getMenuView() ?>
    <?= MainMenu::getMenuView() ?>

    <?= Tpl::view(PATH_TPL . 'index' . DS . 'nav.php') ?>

    <?php if ($msg !== '') { ?>
        <?= Tpl::view(PATH_TPL . 'index' . DS . 'message.php', ['msg' => $msg]) ?>
    <?php } ?>

    <?php if (!is_array(App::content()['content'])) { ?>
        <?= App::content()['content'] ?>
    <?php } else { ?>
        <?= debug(App::content()['content']) ?>
    <?php } ?>

    <?php if ((empty(GV::cookie()['messages_cookies'])) && Session::getUserId() == 0) { ?>
        <div class="messages_cookies uk-background-muted">
            <div class="messages_cookies-wrp">
                <table class="uk-table uk-table-middle uk-margin-remove-bottom">
                    <tr>
                        <td>
                            <p class="uk-text-small"><?= Trl::_('MSG_COOKIE_MSG') ?></p>
                        </td>
                        <td>
                            <button class="uk-button uk-button-primary uk-button-small messages_cookies-close">OK</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script src="/js/cookie_mc.js"></script>
    <?php } ?>

    <script src="/js/uikit.min.js"></script>
    <script src="/js/uikit-icons.min.js"></script>

    <?php if (App::content()['toBottomScript'] != '') { ?>
        <?= App::content()['toBottomScript'] ?>
    <?php } ?>

    <?php if (Session::getTimeDifference() === null) { ?>
        <?= TimeDifference::viewScript() ?>
    <?php } ?>
    <script>
        function loadedHiding() {
            document.body.classList.add('loaded_hiding');
            window.setTimeout(function() {
                document.body.classList.add('loaded');
                document.body.classList.remove('loaded_hiding');
            }, 100)
        }

        window.onload = loadedHiding;
    </script>
</body>

</html>
