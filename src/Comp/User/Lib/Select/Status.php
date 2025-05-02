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

class Status
{
    private static $instance  = null;
    private static $allStatus = null;
    private $checkToForm      = null;

    private function __construct() {}

    public static function getI(): Status
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllStatus(): array
    {
        if (self::$allStatus == null) {
            self::$allStatus = require ForAll::compIncPath('User', 'status');
        }

        return self::$allStatus;
    }

    public function clear(): array
    {
        return self::getAllStatus();
    }

    public function option($userStatus = null)
    {
        return OptionTpl::labelFromValue($this->clear(), $userStatus);
    }

    public function checkToForm()
    {
        if ($this->checkToForm === null) {

            $check = [];

            foreach (self::getAllStatus() as $key => $value) {
                if ($value !== 0) {
                    $check[$key] = (int) self::getAllStatus()[$key];
                }
            }

            $this->checkToForm = $check;
        }

        return $this->checkToForm;
    }

    public function optionToForm(int $userStatus = null)
    {
        return OptionTpl::labelFromKey($this->checkToForm(), $userStatus);
    }

    private function __clone() {}
    public function __wakeup() {}
}
