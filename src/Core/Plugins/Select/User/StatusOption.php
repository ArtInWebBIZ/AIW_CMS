<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\User;

defined('AIW_CMS') or die;

use Core\Plugins\Name\UserStatus as Usn;
use Core\Trl;

class StatusOption
{
    private static $instance  = null;
    private static $allStatus = null;
    private $checkToForm      = null;

    private function __construct() {}

    public static function getI(): StatusOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllStatus(): array
    {
        if (self::$allStatus == null) {
            self::$allStatus = require PATH_INC . 'user' . DS . 'status.php';
        }

        return self::$allStatus;
    }

    public function clear(): array
    {
        return self::getAllStatus();
    }

    public function option($userStatus = null)
    {
        $variable = $this->clear();

        $selected = $userStatus == null ? ' selected="selected"' : '';

        $userStatusOptionHtml = '<option value=""' . $selected . '>' . Trl::_('USER_STATUS_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value === $userStatus ? ' selected="selected"' : '';
            $userStatusOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Usn::getStatusName($value) . '</option>';
        }

        return $userStatusOptionHtml;
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

    public function optionToForm(int $editedUserStatus = null)
    {
        $userStatusOptionHtml = '';

        foreach ($this->checkToForm() as $key => $value) {
            $selected = (int) $this->checkToForm()[$key] === $editedUserStatus ? ' selected="selected"' : '';
            $userStatusOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Usn::getStatusName($value) . '</option>';
        }

        return $userStatusOptionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
