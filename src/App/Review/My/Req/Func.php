<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Review\My\Req;

defined('AIW_CMS') or die;

use Core\Auth;

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

    private $checkAccess = 'null';

    public function checkAccess()
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() === 1
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private function __clone() {}
    public function __wakeup() {}
}
