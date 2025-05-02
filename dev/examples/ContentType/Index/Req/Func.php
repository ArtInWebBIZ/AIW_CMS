<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ContentType\Index\Req;

defined('AIW_CMS') or die;

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
     * Check user`s access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {
            $this->checkAccess = false;
        }

        return $this->checkAccess;
    }

    private function __clone() {}
    public function __wakeup() {}
}
