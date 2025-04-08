<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Session, Trl};
use Core\Plugins\Ssl;

$siteName = Trl::_('OV_SITE_FULL_NAME');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="<?= Session::getLang() ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $subject ?></title>
</head>

<body>
    <table cellpadding="0" cellspacing="0" style="width:600px; margin:30px auto 0; padding:0; font-family: Verdana, Geneva, sans-serif">
        <tr>
            <td style="padding-bottom:20px">
                <table cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0">
                    <tr>
                        <td style="width:20% !important; text-align:center">
                            <img src="<?= Ssl::getLink() ?>/img/logo_h80.png" alt="">
                        </td>
                        <td style="width:80%">
                            <h3 style="text-align:center"><?= $siteName ?></h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <hr style="border:none; border-bottom:1px solid gold">
                <br>
                <?= $message ?>
                <br>
                <hr style="border:none; border-bottom:1px solid gold">
            </td>
        </tr>
    </table>
</body>

</html>
