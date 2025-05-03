<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{App, BaseUrl, ErrorHandler as Errors, Session, Trl, Languages};
use Core\Modules\Menu\LangMenu;
use Core\Modules\Menu\MainMenu;
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

    <?= Breadcrumbs::getI()->getHtml() ?>

    <?php if ($msg !== '') { ?>
        <?= Tpl::view(PATH_TPL . 'index' . DS . 'message.php', ['msg' => $msg]) ?>
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
