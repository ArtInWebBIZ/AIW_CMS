<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Control\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Check\GroupAccess;

class Func
{
    private static $instance = null;
    private $checkAccess = 'null';

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
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() == 1 &&
                GroupAccess::check([5])
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private function __clone() {}
    public function __wakeup() {}
}
