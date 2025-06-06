<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ItemController\EditHistory\Req;

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $fields          = null;

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

            if (GroupAccess::check([5])) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Return item controller fields
     * @return array
     */
    public function fields(): array
    {
        if ($this->fields == null) {
            $this->fields = require PATH_APP . 'ItemController' . DS . 'Add' . DS . 'inc' . DS . 'fields.php';
        }

        return $this->fields;
    }
    #

    private function __clone() {}
    public function __wakeup() {}
}
