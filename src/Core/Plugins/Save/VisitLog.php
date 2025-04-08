<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Save;

defined('AIW_CMS') or die;

use Core\GV;

class VisitLog
{
    private static $instance = null;
    private $userType        = [];
    private $filePath        = '';

    private function __construct()
    {
    }

    public static function getI(): VisitLog
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getUserType()
    {
        if ($this->userType == []) {

            $userAgent = trim(strip_tags(GV::server()['HTTP_USER_AGENT']));

            if (strpos($userAgent, 'YandexBot') !== false) {
                $userType['bot'] = 'YandexBot';
            } elseif (strpos($userAgent, 'Googlebot') !== false) {
                $userType['bot'] = 'Googlebot';
            } elseif (strpos($userAgent, 'bingbot') !== false) {
                $userType['bot'] = 'Bingbot';
            } elseif (strpos($userAgent, 'Mail') !== false) {
                $userType['bot'] = 'Mail.ru';
            } elseif (strpos($userAgent, 'YandexBlogs') !== false) {
                $userType['bot'] = 'YandexBlogs';
            } elseif (strpos($userAgent, 'YandexImage') !== false) {
                $userType['bot'] = 'YandexImages';
            } elseif (strpos($userAgent, 'YandexFavicons') !== false) {
                $userType['bot'] = 'YandexFavicons';
            } elseif (strpos($userAgent, 'YandexDirect') !== false) {
                $userType['bot'] = 'YandexDirect';
            } elseif (strpos($userAgent, 'YandexNews') !== false) {
                $userType['bot'] = 'YandexNews';
            } elseif (strpos($userAgent, 'YandexSomething') !== false) {
                $userType['bot'] = 'YandexSomething';
            } elseif (strpos($userAgent, 'YandexMetrika') !== false) {
                $userType['bot'] = 'YandexMetrika';
            } elseif (strpos($userAgent, 'YandexAntivirus') !== false) {
                $userType['bot'] = 'YandexAntivirus';
            } elseif (strpos($userAgent, 'Feedfetcher-Google') !== false) {
                $userType['bot'] = 'Feedfetcher-Google';
            } elseif (strpos($userAgent, 'Googlebot-Image') !== false) {
                $userType['bot'] = 'Googlebot-Image';
            } elseif (strpos($userAgent, 'Yahoo') !== false) {
                $userType['bot'] = 'Yahoo!';
            } elseif (strpos($userAgent, 'WebCrawler') !== false) {
                $userType['bot'] = 'WebCrawler';
            } elseif (strpos($userAgent, 'ZyBorg') !== false) {
                $userType['bot'] = 'ZyBorg';
            } elseif (strpos($userAgent, 'Scooter') !== false) {
                $userType['bot'] = 'AltaVista';
            } elseif (strpos($userAgent, 'StackRambler') !== false) {
                $userType['bot'] = 'Rambler';
            } elseif (strpos($userAgent, 'Aport') !== false) {
                $userType['bot'] = 'Aport';
            } elseif (strpos($userAgent, 'lycos') !== false) {
                $userType['bot'] = 'Lycos';
            } elseif (strpos($userAgent, 'fast') !== false) {
                $userType['bot'] = 'Fast Search';
            } elseif (strpos($userAgent, 'msnbot') !== false) {
                $userType['bot'] = 'MSN';
            } elseif (strpos($userAgent, 'Nigma.ru') !== false) {
                $userType['bot'] = 'Nigma';
            } elseif (strpos($userAgent, 'ia_archiver') !== false) {
                $userType['bot'] = 'Alexa';
            } elseif (strpos($userAgent, 'Baiduspider') !== false) {
                $userType['bot'] = 'Baidu';
            } elseif (strpos($userAgent, 'Exabot') !== false) {
                $userType['bot'] = 'Exabot';
            } elseif (strpos($userAgent, 'archive.org_bot') !== false) {
                $userType['bot'] = 'Archive.org';
            } elseif (strpos($userAgent, 'Ezooms') !== false) {
                $userType['bot'] = 'Ezooms';
            } elseif (strpos($userAgent, 'GrepNetstat.com Bot') !== false) {
                $userType['bot'] = 'GrepNetstat.com';
            } elseif (strpos($userAgent, 'MJ12bot') !== false) {
                $userType['bot'] = 'Majestic-12';
            } elseif (strpos($userAgent, 'AhrefsBot') !== false) {
                $userType['bot'] = 'Ahrefs';
            } elseif (strpos($userAgent, 'TurnitinBot') !== false) {
                $userType['bot'] = 'Turnitin';
            } elseif (strpos($userAgent, 'discobot') !== false) {
                $userType['bot'] = 'Discobot';
            } elseif (strpos($userAgent, 'Subscribe.Ru') !== false) {
                $userType['bot'] = 'Subscribe';
            } elseif (strpos($userAgent, 'TOP.NET.RU') !== false) {
                $userType['bot'] = 'TOP.NET.RU';
            } elseif (strpos($userAgent, 'SISTRIX Crawler') !== false) {
                $userType['bot'] = 'SISTRIX';
            } elseif (strpos($userAgent, 'Wotbox') !== false) {
                $userType['bot'] = 'Wotbox';
            } else {
                $userType['user'] = htmlspecialchars(substr($userAgent, 0, 80)); //обрезаем USER-AGENT до 80 символов
            }

            $this->userType = $userType;
        }

        return $this->userType;
    }

    private function setFileName()
    {

        $year  = userDate("Y", time());
        $month = userDate("m", time());
        $day   = userDate("d", time());
        $hour  = userDate("H", time());
        $path  = PATH_BASE . $year . DS . $month . DS . $day . DS . $hour . DS;

        if ($this->filePath == '') {

            if (isset($this->getUserType()['bot'])) {
                $filePath = $path . 'bot_log.txt';
            } elseif (isset($this->getUserType()['user'])) {
                $filePath = $path . 'user_log.txt';
            }

            $this->filePath = $filePath;
        }

        return $this->filePath;
    }

    public function saveVisitToLog()
    {
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}

$file    = "base_user"; //имя файла с логами пользователей
$col_zap = 3499; //записей в логе пользователей
