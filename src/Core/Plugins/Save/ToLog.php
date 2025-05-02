<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Save;

defined('AIW_CMS') or die;

use Core\Config;

class ToLog
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): ToLog
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function blockCounter(string $fileLine): bool
    {
        if (Config::getCfg('CFG_DEBUG') === true) {

            file_put_contents(
                PATH_LOG . "PHP_errors.log",
                date(Config::getCfg('CFG_DATE_TIME_SECONDS_FORMAT')) . "\r\n" .
                    $fileLine . "\r\n" . 'Session block_counter + 1' . "\r\n" . '–' . "\r\n",
                FILE_APPEND | LOCK_EX
            );
        }

        return true;
    }

    private function __clone() {}
    public function __wakeup() {}
}
