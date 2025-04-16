<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{App, BaseUrl, ErrorHandler as Errors, Session, Trl};
use Core\Modules\LangMenu\LangMenu;
use Core\Modules\MainMenu\MainMenu;
use Core\Modules\UserMenu\UserMenu;
use Core\Plugins\Ssl;

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
    <?= App::content()['toTopStyles'] = App::content()['toTopStyles'] != '' ? App::content()['toTopStyles'] : '' ?>
    <link rel="stylesheet" href="/css/uikit<?= $rtl ?>.min.css">
    <link rel="stylesheet" href="/css/style.min.css">
    <?= App::content()['toTopScript'] = App::content()['toTopScript'] != '' ? App::content()['toTopScript'] : '' ?>
</head>

<body>
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

    <?php if (App::content()['msg'] !== '') { ?>
        <section class="uk-section uk-section-xsmall">
            <div class="uk-container uk-container-xsmall">
                <div class="uk-grid uk-flex uk-flex-center">
                    <div class="uk-width-1-1">
                        <?= App::content()['msg'] ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <div class="error-page">
        <div class="error-page-img">
            <img src="/img/icons/disappointed-face.svg" alt="" class="uk-width-1-1">
        </div>
        <div class="error-page-text">
            <h2 class="uk-text-center uk-heading-2xlarge uk-margin-small line-color">404</h2>
            <h5 class="uk-text-center uk-heading-medium uk-margin-small line-color"><?= Trl::_('OV_PAGE404') ?></h5>
        </div>
    </div>

    <script src="/js/uikit.min.js"></script>
    <script src="/js/uikit-icons.min.js"></script>

    <?php if (App::content()['toBottomScript'] != '') { ?>
        <?= App::content()['toBottomScript'] ?>
    <?php } ?>

</body>

</html>
