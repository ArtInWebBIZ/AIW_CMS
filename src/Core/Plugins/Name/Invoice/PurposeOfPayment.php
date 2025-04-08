<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name\Invoice;

defined('AIW_CMS') or die;

use Core\Trl;

class PurposeOfPayment
{
    private static $allValues = [];

    public static function getName($value)
    {
        return Trl::_(array_search($value, self::getAllValues()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllValues());
    }

    private static function getAllValues()
    {
        if (self::$allValues == []) {
            self::$allValues = require PATH_INC . 'invoice' . DS . 'purposeOfPayment.php';
        }

        return self::$allValues;
    }
}
