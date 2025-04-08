<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Create\Background;

defined('AIW_CMS') or die;

class Bg
{
    private static $getBg = [];

    public static function getBg()
    {
        if (self::$getBg == []) {

            $bgArray = require PATH_INC . 'content' . DS . 'bgPt.php';

            self::$getBg = $bgArray[random_int(0, count($bgArray) - 1)];
        }

        return self::$getBg;
    }
}
