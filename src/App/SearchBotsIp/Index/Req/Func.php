<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\SearchBotsIp\Index\Req;

defined('AIW_CMS') or die;

use Core\Content;
use Core\Plugins\Check\GroupAccess;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return …
     * @return bool
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (GroupAccess::check([5])) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private function __clone() {}
    public function __wakeup() {}
}
