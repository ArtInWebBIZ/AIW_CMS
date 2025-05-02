<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\User\Lib\Select;

defined('AIW_CMS') or die;

use Core\Plugins\Lib\ForAll;
use Core\Plugins\Select\OptionTpl;

class Group
{
    private static $instance = null;
    private $allGroups       = [];
    private $clear           = [];

    private function __construct() {}

    public static function getI(): Group
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getAllGroups()
    {
        if ($this->allGroups == []) {

            $allGroups = require ForAll::compIncPath('User', 'group');

            foreach ($allGroups as $key => $value) {

                if ($allGroups[$key] !== 0) {
                    $this->allGroups[$key] = $allGroups[$key];
                }
            }
        }

        return $this->allGroups;
    }

    public function clear()
    {
        return $this->getAllGroups();
    }

    public function option($userGroup = null)
    {
        return OptionTpl::labelFromKey($this->clear(), $userGroup);
    }

    public function optionToForm($userGroup = null)
    {
        return OptionTpl::labelFromKey($this->clear(), $userGroup);
    }

    private function __clone() {}
    public function __wakeup() {}
}
