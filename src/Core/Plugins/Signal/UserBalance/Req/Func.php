<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Signal\UserBalance\Req;

defined('AIW_CMS') or die;

use Core\Auth;

class Func
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';
    /**
     * Return users access rule
     * @return bool
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserId() > 0
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
