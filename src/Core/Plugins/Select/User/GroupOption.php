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
use Core\Plugins\Name\UserGroup as Ugn;
use Core\Trl;

class GroupOption
{
    private static $instance = null;
    private $allGroups       = [];
    private $clear           = [];

    private function __construct()
    {
    }

    public static function getI(): GroupOption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getAllGroups()
    {
        if ($this->allGroups == []) {

            $allGroups = require PATH_INC . 'user' . DS . 'group.php';

            foreach ($allGroups as $key => $value) {

                if ($allGroups[$key] == 0) {
                    continue;
                } else {
                    $this->allGroups[$key] = $allGroups[$key];
                }
            }
        }

        return $this->allGroups;
    }

    public function clear()
    {
        if ($this->clear == []) {

            foreach ($this->getAllGroups() as $key => $value) {

                if (
                    (Auth::getUserGroup() < 3 &&
                        $this->getAllGroups()[$key] < 3
                    ) ||
                    (Auth::getUserGroup() > 2 &&
                        $this->getAllGroups()[$key] < Auth::getUserGroup()
                    )
                ) {

                    $this->clear[$key] = $this->getAllGroups()[$key];
                }
            }
        }

        return $this->clear;
    }

    public function option($userGroup = null)
    {
        $variable = $this->clear();

        $selected = $userGroup === null ? ' selected="selected"' : '';

        $userGroupOptionHtml = '<option value=""' . $selected . '>' . Trl::_('USER_GROUP_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value == $userGroup ? ' selected="selected"' : '';
            $userGroupOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Ugn::getGroupName($value) . '</option>';
        }

        return $userGroupOptionHtml;
    }

    public function optionToForm($userGroup = null)
    {
        $variable = $this->clear();

        $userGroupOptionHtml = '';

        foreach ($variable as $key => $value) {
            $selected = $value == $userGroup ? ' selected="selected"' : '';
            $userGroupOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . Ugn::getGroupName($value) . '</option>';
        }

        return $userGroupOptionHtml;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
