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
    private static $ipAccess     = false;
    private static $searchBotsIp = null;
    /**
     * Check current user is search bot or not
     * @param string $ip
     * @return boolean
     */
    public static function getIpAccess(string $ip): bool
    {
        $searchBotsIp = self::searchBotsIp();

        $ipLong = ip2long($ip);

        foreach ($searchBotsIp as $key => $value) {

            if (
                $ipLong >= $searchBotsIp[$key]['start_range'] &&
                $ipLong <= $searchBotsIp[$key]['end_range']
            ) {
                self::$ipAccess = true;
                break;
            }
            if ($ipLong < $searchBotsIp[$key]['end_range']) {
                break;
            }
        }
        unset($key, $value);

        return self::$ipAccess;
    }
    /**
     * Return all search bots ip from database
     * @return array
     */
    private static function searchBotsIp(): array
    {
        if (self::$searchBotsIp === null) {

            self::$searchBotsIp = DB::getAll(
                "SELECT `start_range`, `end_range`, `engine_name` FROM `search_bots_ip` ORDER BY `start_range` ASC",
                []
            );
            #
        }

        return self::$searchBotsIp;
    }
    #
}
