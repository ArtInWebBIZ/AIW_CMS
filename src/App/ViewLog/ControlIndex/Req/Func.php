<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ViewLog\ControlIndex\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Check\GroupAccess;

class Func
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check users access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        return Auth::getUserStatus() === 1 &&
            GroupAccess::check([5]) ?
            true : false;
    }

    private function __clone() {}
    public function __wakeup() {}
}
