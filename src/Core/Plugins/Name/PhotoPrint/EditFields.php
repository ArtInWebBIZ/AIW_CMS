<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Name\PhotoPrint;

defined('AIW_CMS') or die;

use Core\Trl;

class EditFields
{
    private static $allFields = [];

    private static function getAllFields()
    {
        if (self::$allFields == []) {
            self::$allFields = require PATH_INC . 'photoPrint' . DS . 'fields.php';
        }

        return self::$allFields;
    }

    public static function getNameKey($value)
    {
        return array_search($value, self::getAllFields());
    }

    public static function getName($value)
    {
        return Trl::_(array_search($value, self::getAllFields()));
    }
}
