<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\SearchBotsIp;

defined('AIW_CMS') or die;

use Core\DB;

class CheckSearchBotsIp
{
    private static $ipAccess    = false;
    private static $ipWhiteList = null;

    public static function getIpAccess($ip): bool
    {
        $ipWhiteList = self::ipWhiteList();

        $ipLong = ip2long($ip);

        foreach ($ipWhiteList as $key => $value) {

            if (
                $ipLong >= $ipWhiteList[$key]['start_range'] &&
                $ipLong <= $ipWhiteList[$key]['end_range']
            ) {
                self::$ipAccess = true;
                break;
            }
            if ($ipLong < $ipWhiteList[$key]['end_range']) {
                break;
            }
        }
        unset($key, $value);

        return self::$ipAccess;
    }
    /**
     * Return …
     * @return array
     */
    private static function ipWhiteList(): array
    {
        if (self::$ipWhiteList === null) {

            self::$ipWhiteList = DB::getAll(
                "SELECT `start_range`, `end_range`, `engine_name` FROM `search_bots_ip` ORDER BY `start_range` ASC",
                []
            );;
            #
        }

        return self::$ipWhiteList;
    }
    #
}
