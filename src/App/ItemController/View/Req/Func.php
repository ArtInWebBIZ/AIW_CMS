<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\ItemController\View\Req;

defined('AIW_CMS') or die;

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
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;
        }

        return $this->checkAccess;
    }

    private function __clone() {}
    public function __wakeup() {}
}
