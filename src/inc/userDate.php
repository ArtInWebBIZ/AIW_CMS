<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Session;

function userDate(string $format, int $time = 0): string
{
    $time = $time === 0 ? time() : $time;

    return date($format, $time + (gettimeofday()['minuteswest'] * 60) + Session::getTimeDifference());
}

function metaDate(int $time): string
{
    $minutesWest = gettimeofday()['minuteswest'];

    $minutesWest = -$minutesWest / 60;
    $minutesWest = round($minutesWest, 2);
    $minutesWest = explode(".", $minutesWest);

    if (
        iconv_strlen($minutesWest[0]) == 1 &&
        $minutesWest[0] >= 0
    ) {
        $minutesWest[0] = '0' . $minutesWest[0];
    } elseif (
        iconv_strlen($minutesWest[0]) == 2 &&
        $minutesWest[0] < 0
    ) {
        $minutesWest[0] = '-0' . -$minutesWest[0];
    }

    if (isset($minutesWest[1])) {
        $minutesWest[1] = round(($minutesWest[1] * 60 / 100), 0);
        if (iconv_strlen($minutesWest[1]) == 1) {
            $minutesWest[1] = '0' . $minutesWest[1];
        }
    } else {
        $minutesWest[1] = '00';
    }

    $minutesWest = implode(":", $minutesWest);
    $minutesWest = $minutesWest[0] != '-' ? '+' . $minutesWest : $minutesWest;

    return date("Y-m-d\TH:i:s", ($time)) . $minutesWest;
}
