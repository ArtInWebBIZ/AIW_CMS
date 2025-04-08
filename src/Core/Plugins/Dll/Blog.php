<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Dll;

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
            $this->getAllStatusList = require PATH_INC . 'blog' . DS . 'status.php';
        }

        return $this->getAllStatusList;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
