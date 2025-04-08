<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name\Other;

defined('AIW_CMS') or die;

use Core\Trl;

class NoYes
{
    private static $all = [];

    public static function getName($value)
    {
        return Trl::_(array_search($value, self::getAll()));
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAll());
    }

    private static function getAll()
    {
        if (self::$all == []) {
            self::$all = require PATH_INC . 'other' . DS . 'noYes.php';
        }

        return self::$all;
    }

    public static function getColor($value)
    {
        $params = [
            0 => 'primary', // не оплачено
            1 => 'success', // оплачено
        ];

        if (isset($params[$value])) {
            return '<span class="uk-text-' . $params[$value] . '">' . self::getName($value) . '</span>';
        } else {
            return self::getName($value);
        }
    }
}
