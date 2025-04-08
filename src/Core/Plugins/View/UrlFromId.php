<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\View;

defined('AIW_CMS') or die;

use Core\Plugins\Model\DB;

class UrlFromId
{
    public static $urlList = [];

    public static function url(int $urlId)
    {
        if (isset(self::$urlList[$urlId])) {
            return self::$urlList[$urlId];
        } else {
            self::getUrlFromDb($urlId);
            return self::$urlList[$urlId];
        }
    }

    private static function getUrlFromDb(int $urlId)
    {
        self::$urlList[$urlId] = DB::getI()->getValue(
            [
                'table_name' => 'list_page',
                'select'     => 'url',
                'where'      => '`id` = :id',
                'array'      => ['id' => $urlId],
            ]
        );

        return self::$urlList;
    }
}
