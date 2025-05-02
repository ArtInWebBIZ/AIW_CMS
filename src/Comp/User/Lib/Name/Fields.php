<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\User\Lib\Name;

defined('AIW_CMS') or die;

use Core\Plugins\Lib\ForAll;
use Core\Trl;

class Fields
{
    private static $allFields = [];
    /**
     * Get all fields for user`s content type
     * @return array
     */
    private static function getAllFields(): array
    {
        if (self::$allFields == []) {
            self::$allFields = require ForAll::compIncPath('User', 'fields');
        }

        return self::$allFields;
    }

    public static function getName($value)
    {
        return isset(self::getAllFields()[$value]) ? Trl::_(self::getAllFields()[$value]) : $value;
    }
}
