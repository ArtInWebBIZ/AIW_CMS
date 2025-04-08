<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\User;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Name\User\PaidType;
use Core\Trl;

class PaidTypeOption
{
    private static $instance    = null;
    private static $allPaidType = 'null';
    private $checkToForm        = null;

    private function __construct()
    {
    }

    public static function getI(): PaidTypeOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllPaidType()
    {
        if (self::$allPaidType == 'null') {
            self::$allPaidType = require PATH_INC . 'user' . DS . 'paidType.php';
        }

        return self::$allPaidType;
    }

    public function clear()
    {
        return self::getAllPaidType();
    }

    public function option($currentPaidType = null)
    {
        $variable = $this->clear();

        $selected = $currentPaidType == null ? ' selected="selected"' : '';

        $userPaidTypeOptionHtml = '<option value=""' . $selected . '>' . Trl::_('USER_PAID_TYPE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value === $currentPaidType ? ' selected="selected"' : '';
            $userPaidTypeOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . PaidType::getPaidTypeName($value) . '</option>';
        }

        return $userPaidTypeOptionHtml;
    }

    public function checkToForm($editedUserGroup = null)
    {
        if ($this->checkToForm === null) {

            $check = [];

            foreach (self::getAllPaidType() as $key => $value) {

                if (
                    Auth::getUserGroup() > 3
                    && $value != 0
                    && $editedUserGroup < Auth::getUserGroup()
                ) {

                    $check[$key] = (int) self::getAllPaidType()[$key];
                }
            }

            $this->checkToForm = $check;
        }

        return $this->checkToForm;
    }

    public function optionToForm(int $editedUserGroup, int $currentUserStatus = 0)
    {
        $variable = $this->checkToForm($editedUserGroup);

        $userPaidTypeOptionHtml = '';

        foreach ($variable as $key => $value) {
            $selected = $value === $currentUserStatus ? ' selected="selected"' : '';
            $userPaidTypeOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Usn::getStatusName($value) . '</option>';
        }

        return $userPaidTypeOptionHtml;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
