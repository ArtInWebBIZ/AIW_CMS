<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\{Clean, Router};

class IntPageAlias
{
    private static $intPageAlias = 'null';
    /**
     * Check page alias integer this or not
     * @return mixed // integer or false
     */
    public static function check(): mixed
    {
        if (self::$intPageAlias === 'null') {
            /**
             * Check pages alias
             */
            self::$intPageAlias = Clean::unsInt(Router::getPageAlias());
            /**
             * If $intPageAlias not false
             */
            if (
                self::$intPageAlias !== false &&
                self::$intPageAlias != 0
            ) {
                /**
                 * Check symbol minus
                 */
                if (self::$intPageAlias < 0) {
                    self::$intPageAlias = self::$intPageAlias * -1;
                }
            }

            if (self::$intPageAlias == 0) {
                self::$intPageAlias = false;
            }
        }

        return self::$intPageAlias;
    }
}
