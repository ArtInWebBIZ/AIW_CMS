<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Logout\Req;

defined('AIW_CMS') or die;

use Core\{Clean, Router};
use Core\Plugins\Ssl;

class Func
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function referer()
    {
        if (Router::getGetStr() != '') {

            $referer = explode("&", Router::getGetStr());

            $all = [];

            foreach ($referer as $key => $value) {
                $all[$key]    = explode("=", $value);
                $newKey       = $all[$key][0];
                $newValue     = $all[$key][1];
                $all[$newKey] = $newValue;
                unset($all[$key]);
            }
            unset($key, $value);

            if (
                isset($all['referer']) &&
                str_contains($all['referer'], Ssl::getLinkLang())
            ) {
                /**
                 * Check correct host and
                 * Return correct referrers link
                 */
                return Clean::url($all['referer']);
                #
            } else {
                return Ssl::getLinkLang();
            }
            #
        } else {
            return Ssl::getLinkLang();
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
