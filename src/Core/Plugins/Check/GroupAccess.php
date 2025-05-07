<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Lib\ForAll;

class GroupAccess
{
    private static $managerGroups = null;
    /**
     * Check currently user access
     * @param array $groups
     * @return boolean
     */
    public static function check(array $groups): bool
    {
        return Auth::getUserStatus() === 1 ? in_array(Auth::getUserGroup(), $groups, true) : false;
    }
    /**
     * Return true or false current users group in managers list
     * @return bool
     */
    public static function managerGroups(): bool
    {
        if (self::$managerGroups === null) {

            self::$managerGroups = false;

            $path = ForAll::compIncPath('User', 'managers');

            if (file_exists($path)) {

                $managerGroups = array_flip(require $path);

                if (isset($managerGroups[Auth::getUserGroup()])) {
                    self::$managerGroups = true;
                }
            }
        }

        return self::$managerGroups;
    }
    #
}
