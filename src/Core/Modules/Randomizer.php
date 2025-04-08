<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules;

defined('AIW_CMS') or die;

class Randomizer
{
    /**
     * Return randomized string
     * @param integer $start - minimal count symbols in string
     * @param integer $end - maximal count symbols in string
     * @return string
     */
    public static function getRandomStr($start = 16, $end = 32): string
    {
        $toRand    = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
        $toRandLen = iconv_strlen($toRand) - 1;

        $startOk = $start > $end ? $end : $start;
        $endOk   = $start > $end ? $start : $end;

        $count = $start == $end ? $start : random_int($startOk, $endOk);

        $randomStr = '';

        for ($i = 0; $i < $count; $i++) {
            $symbolNumber = random_int(0, $toRandLen);
            $randomStr .= $toRand[$symbolNumber];
        }

        return $randomStr;
    }

    public static function fromArray(array $array, $start = 16, $end = 32)
    {
        $toRandLen = count($array) - 1;

        $startOk = $start > $end ? $end : $start;
        $endOk   = $start > $end ? $start : $end;

        $count = $start == $end ? $start : random_int($startOk, $endOk);

        $randomStr = '';

        for ($i = 0; $i < $count; $i++) {
            do {
                $symbolNumber = random_int(0, $toRandLen);
                $randomStr .= $array[$symbolNumber];
            } while ($array[$symbolNumber] == '');
        }

        return $randomStr;
    }
}
