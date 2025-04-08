<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item\View;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;

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
    #
    private $checkAccess = 'null';
    /**
     * Return users access to page
     * @return bool
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                is_array($this->itemParams()) &&
                is_array($this->checkItem()) &&
                $this->itemParams()['access'] === true
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Return item parameters
     * @return mixed // item params array or false
     */
    public function itemParams(): mixed
    {
        return Item::getI()->itemParams();
    }
    #
    /**
     * Return items array or false
     * @return mixed // array or false
     */
    private function checkItem(): mixed
    {
        return Item::getI()->checkItem();
    }

    private function __clone() {}
    public function __wakeup() {}
}
