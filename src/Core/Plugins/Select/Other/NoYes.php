<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Select\Other;

defined('AIW_CMS') or die;

use Core\Plugins\Select\OptionTpl;

class NoYes
{
    private static $all = null;
    /**
     * Get all logic values
     * @return array
     */
    private static function getAll(): array
    {
        if (self::$all === null) {
            self::$all = require PATH_INC . 'for-all' . DS . 'noYes.php';
        }

        return self::$all;
    }
    /**
     * Get for all user`s logic values
     * @return array
     */
    public static function clear(): array
    {
        return self::getAll();
    }
    /**
     * Get to select fields type correct option values
     * @param integer|null $fieldValue
     * @return string
     */
    public static function option(int $fieldValue = null): string
    {
        return OptionTpl::labelFromKey(self::clear(), $fieldValue);
    }
}
