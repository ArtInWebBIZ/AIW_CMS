<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;

class NotLangItemFields
{
    /**
     * Return correct filter fields
     * @return array
     */
    public static function getNotLangItemFields(): array
    {
        return array_merge(
            Item::getI()->getAllItemFields()['default'],
            Item::getI()->getAllItemFields()['fieldset'],
            Item::getI()->getAllItemFields()['filters'],
        );
    }
}
