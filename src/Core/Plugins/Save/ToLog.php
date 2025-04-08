<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Save;

defined('AIW_CMS') or die;

use Core\{BaseUrl, Config, Router, Trl};
use Core\Plugins\Ssl;

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

// $file    = "base_bot"; //имя файла с логами ботов
// $col_zap = 2499; //записей в логе ботов

// //записываем логи в файл с блокировкой
// $l_cash = '';
// $fh     = fopen($file, "a+");
// flock($fh, LOCK_EX);
// fseek($fh, 0);
// while (!feof($fh)) {
//     $l_cash .= fread($fh, 8192);
// }

// $lines = explode("\n", $l_cash);
// while (count($lines) > $col_zap) {
//     array_shift($lines);
// }

// $l_cash = implode("\n", $lines);
// $l_cash .= userDate("H:i:s d.m") . "|" . $bot . "|" . GV::server()['REMOTE_ADDR'] . "|" .
//     htmlspecialchars(GV::server()['REQUEST_URI']) . "\n";
// ftruncate($fh, 0);
// fwrite($fh, $l_cash);
// flock($fh, LOCK_UN);
// fclose($fh);
