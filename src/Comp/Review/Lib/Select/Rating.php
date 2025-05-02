<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Review\Lib\Select;

defined('AIW_CMS') or die;

use Core\Plugins\Lib\ForAll;
use Core\Plugins\Select\OptionTpl;

class Rating
{
    private static $instance   = null;
    private static $allRatings = null;

    private function __construct() {}

    public static function getI(): Rating
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllRatings(): array
    {
        if (self::$allRatings === null) {
            self::$allRatings = require ForAll::compIncPath('Review', 'rating');
        }

        return self::$allRatings;
    }

    public function clear()
    {
        return self::getAllRatings();
    }

    public function option($rating = null)
    {
        return OptionTpl::labelFromKey($this->clear(), $rating);
    }

    private function __clone() {}
    public function __wakeup() {}
}
