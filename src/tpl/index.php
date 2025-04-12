<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{App, BaseUrl, ErrorHandler as Errors, Session, Trl, Languages};
use Core\Modules\LangMenu\LangMenu;
use Core\Modules\MainMenu\MainMenu;
use Core\Modules\UserMenu\UserMenu;
use Core\Plugins\{Ssl, View\Tpl};
use Core\Modules\Breadcrumbs;

include PATH_TPL . 'index' . DS . 'redirect.php';

$rtl = Session::getRtl() == 1 ? '-rtl' : '';

?>
<!DOCTYPE html>
<html lang="<?= Session::getLang() ?>">

<head itemscope itemtype="http://schema.org/WPHeader">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if (App::content()['description'] != '') { ?>
        <meta itemprop="description" name="description" content="<?= App::content()['description'] ?>">
    <?php } ?>
    <?php if (App::content()['keywords'] != '') { ?>
        <meta itemprop="keywords" name="keywords" content="<?= App::content()['keywords'] ?>">
    <?php } ?>
    <?php if (App::content()['author'] != '') { ?>
        <meta itemprop="author" name="author" content="<?= App::content()['author'] ?>">
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= App::content()['refresh'] ?>
    <?= App::content()['meta'] ?>
    <?= App::content()['canonical'] ?>
    <?= App::content()['alternate'] ?>
    <meta name="robots" content="<?= App::content()['robots'] ?>">
    <base href="<?= Ssl::getLink() . BaseUrl::getBaseUrl() ?>">
    <title itemprop="headline"><?= Trl::_(App::content()['title']) ?> - <?= Trl::_('OV_SITE_NAME') ?></title>
    <link rel="image_src" href="<?= App::content()['image'] ?>">
    <meta property="og:title" content="<?= Trl::_(App::content()['title']) ?> - <?= Trl::_('OV_SITE_NAME') ?>">
    <meta property="og:url" content="<?= Ssl::getLink() . BaseUrl::getBaseUrl() ?>">
    <meta property="og:image" content="<?= App::content()['image'] ?>">
    <?= App::content()['og'] ?>
    <?= Tpl::view(PATH_TPL . 'index' . DS . 'linkToFontsOLD.php') ?>
    <link rel="stylesheet" href="/css/uikit<?= $rtl ?>.min.css">
    <link rel="stylesheet" href="/css/style.min.css">
    <?= App::content()['toTopStyles'] = App::content()['toTopStyles'] != '' ? App::content()['toTopStyles'] : '' ?>
    <?= App::content()['toTopScript'] = App::content()['toTopScript'] != '' ? App::content()['toTopScript'] : '' ?>
    <script src="/js/uikit.min.js" defer></script>
    <script src="/js/uikit-icons.min.js" defer></script>
</head>

<body>
    <div class="preloader">
        <svg class="preloader__image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
            </path>
        </svg>
    </div>
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

    <?php if (count(Languages::langList()) > 1) { ?>
        <?= LangMenu::getMenuView() ?>
    <?php } ?>

    <?= MainMenu::getMenuView() ?>

    <?php include_once PATH_TPL . 'index' . DS . 'nav.php'; ?>

    <?= Breadcrumbs::getI()->getHtml() ?>

    <?php if ($msg !== '') { ?>
        <section class="uk-section uk-section-xsmall">
            <div class="uk-container uk-container-xsmall">
                <div class="uk-grid uk-flex uk-flex-center">
                    <div class="uk-width-1-1">
                        <?= $msg ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php if (!is_array(App::content()['content'])) { ?>
        <?= App::content()['content'] ?>
    <?php } else { ?>
        <?= debug(App::content()['content']) ?>
    <?php } ?>

    <?= Tpl::view(PATH_TPL . 'index' . DS . 'footer.php') ?>

    <?= '<!-- messages_cookies -->' ?>

    <?php if (App::content()['toBottomScript'] != '') { ?>
        <?= App::content()['toBottomScript'] ?>
    <?php } ?>

    <?= '<!-- time_difference -->' ?>

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
