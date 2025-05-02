<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Blog\Lib;

use Core\Plugins\Lib\ForAll;

defined('AIW_CMS') or die;

class Blog
{
    private static $instance = null;
    private $getAllStatusList = null;

    private function __construct() {}

    public static function getI(): Blog
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return in array all blog status list
     * @return array
     */
    public function getAllStatusList(): array
    {
        if ($this->getAllStatusList === null) {
            $this->getAllStatusList = require ForAll::compIncPath('Blog', 'status');
        }

        return $this->getAllStatusList;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
