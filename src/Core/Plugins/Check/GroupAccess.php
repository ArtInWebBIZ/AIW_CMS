<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\Auth;

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
        return in_array(Auth::getUserGroup(), $groups, true);
    }
    /**
     * Return true or false current users group in managers list
     * @return bool
     */
    public static function managerGroups(): bool
    {
        if (self::$managerGroups === null) {

            self::$managerGroups = false;

            if (file_exists(PATH_INC . 'for-all' . DS . 'managerGroups.php')) {

                $managerGroups = array_flip(require PATH_INC . 'for-all' . DS . 'managerGroups.php');

                if (isset($managerGroups[Auth::getUserGroup()])) {
                    self::$managerGroups = true;
                }
            }
        }

        return self::$managerGroups;
    }
    #
}
