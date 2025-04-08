<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Clean, GV};

$trl = require PATH_LANG . $v['lang'] . DS . 'die.php';

if (
    !isset(GV::cookie()['time_difference']) ||
    !is_int(Clean::int(GV::cookie()['time_difference']))
) {
    $down = date("Y-m-d H:i:s", (time() + (gettimeofday()['minuteswest'] * 60) + $v['refresh'])) . '+00:00 (UTC time)';
} else {
    $down = date("Y-m-d H:i:s", (time() + ((floor(Clean::int(GV::cookie()['time_difference']) / 60) + gettimeofday()['minuteswest']) * 60) + $v['refresh']));
}

?>
<!DOCTYPE html>
<html lang="<?= $v['lang'] ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="refresh" content="<?= $v['refresh'] ?>">
    <title><?= $trl[$v['title']] ?></title>
    <style>
        body {
            font-size: 24px;
        }

        .error-div {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: calc(100% - 60px);
            min-height: calc(96vh - 60px);
            padding: 30px;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .color-red {
            color: red;
        }

        .alert-danger {
            display: block;
            overflow: hidden;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="error-div">
        <div class="alert-danger">
            <h2 class="text-center text-bold color-red"><?= $trl[$v['h3']] ?>&nbsp;&nbsp;!!!</h2>
            <p><?= $trl[$v['p']] ?></p>
            <?php if (isset($v['h4'])) { ?>
                <h4 class="text-center text-bold"><?= $trl[$v['h4']] ?></h4>
            <?php } ?>
            <?= $trl['DIE_SITE_AVAILABLE_AFTER'] . ' <strong>' . $down . '</strong>' ?>
        </div>
    </div>
</body>

</html>
