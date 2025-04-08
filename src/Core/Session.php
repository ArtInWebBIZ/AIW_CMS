<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\{Clean, Config, GV, Languages, DB};
use Core\Modules\Randomizer;
use Core\Modules\SearchBotsIp\CheckSearchBotsIp;
use Core\Plugins\ParamsToSql;
use Core\Plugins\Save\ToLog;

class Session
{
    private static $session     = [];
    private static $sessionTime = 'null';
    private static $countIp     = 'null';

    public static function getSession()
    {
        /**
         * If the session has not yet been defined
         */
        if (self::$session === []) {
            /**
             * First we clear old sessions that have expired
             */
            self::delOldSession();
            /**
             * Checking the number of sessions with this IP
             * same as current user
             */
            if (self::getCountIp() > 4) {

                DB::set(
                    "UPDATE `session` SET " . ParamsToSql::getSet(
                        $set = [
                            'user_id' => 0,
                            'edited' => time(),
                            'save_session' => 0,
                            'enabled_to' => time() + Config::getCfg('CFG_MIN_SESSION_TIME')
                        ]
                    ) . " WHERE `user_ip` = :user_ip AND `tmp_status` < :tmp_status",
                    array_merge(
                        $set,
                        [
                            'user_ip' => self::setUserIp(),
                            'tmp_status' => 1
                        ]
                    )
                );

                $v = [
                    'lang'    => self::setLang(),
                    'refresh' => Config::getCfg('CFG_MIN_SESSION_TIME'),
                    'title'   => 'DIE_BLOCKED_BY_IP',
                    'h3'      => 'DIE_BLOCKED_BY_IP',
                    'p'       => 'DIE_BLOCKED_BY_IP_INFO',
                ];

                ob_start();
                require PATH_TPL . 'die' . DS . 'die.php';
                echo ob_get_clean();

                die();
            }
            /**
             * Getting a session in an associative array from the database
             */
            self::$session = DB::getRow(
                "SELECT * FROM `session`
                WHERE `session_key` = :session_key",
                ['session_key' => self::getSessionKey()]
            );
            /**
             * If the session is empty,
             */
            if (self::$session === false) {

                self::$session = self::addSession();

                self::standardCookieUpdate();
                #
            } else { // If a session with such a key is received from the database
                /**
                 * If the user is not a search bot
                 * Checking the ratio of page loads to time
                 */
                if (self::getSearchBotsIp() != 1) {
                    /**
                     * die, addSession, updSession
                     */
                    if (self::$session['views'] > 2) {
                        /**
                         * Checking the interval for creating a new session
                         * Refresh page to 10 second
                         * die
                         */
                        if (
                            self::$session['next_page_time'] == 1 &&
                            (time() - self::$session['edited']) < 3
                        ) {
                            self::dieFunc(
                                [
                                    'refresh' => 10,
                                    'title'   => 'DIE_ERROR_NEXT_PAGE_TIME',
                                    'h3'      => 'DIE_ERROR_NEXT_PAGE_TIME',
                                    'p'       => 'DIE_ERROR_NEXT_PAGE_TIME_INFO',
                                    'h4'      => 'DIE_PAGE_RESET',
                                    'file_line' => __FILE__ . ' - ' . __LINE__ . "\r\n" . Trl::_('DIE_ERROR_NEXT_PAGE_TIME') . "\r\n" . Trl::_('DIE_PRESUMABLY')
                                ]
                            );
                        }
                        /**
                         * If the number of session locks is more than 3,
                         * block the user for 15 minutes
                         * die
                         */
                        if (
                            self::$session['block_counter'] > 3
                        ) {
                            self::dieFunc(
                                [
                                    'refresh' => Config::getCfg('CFG_MIN_SESSION_TIME'),
                                    'title'   => 'DIE_ERROR_LIMIT_EXCEEDED',
                                    'h3'      => 'DIE_ERROR_LIMIT_EXCEEDED',
                                    'p'       => 'DIE_ERROR_LIMIT_EXCEEDED_INFO',
                                    'file_line' => __FILE__ . ' - ' . __LINE__ . "\r\n" . Trl::_('DIE_ERROR_LIMIT_EXCEEDED')
                                ]
                            );
                        }
                        /**
                         * If the number of views for an unregistered user
                         * more than 75 blocked user from 15 minutes
                         * die
                         */
                        if (
                            (
                                self::$session['tmp_status'] == -1 ||
                                self::$session['tmp_status'] == 0
                            ) &&
                            self::$session['views'] >= 75
                        ) {
                            self::dieFunc(
                                [
                                    'refresh' => Config::getCfg('CFG_MIN_SESSION_TIME'),
                                    'title'   => 'DIE_LIMIT_PAGE_VIEWS',
                                    'h3'      => 'DIE_LIMIT_PAGE_VIEWS',
                                    'p'       => 'DIE_LIMIT_PAGE_VIEWS_INFO',
                                    'file_line' => __FILE__ . ' - ' . __LINE__ . "\r\n" . Trl::_('DIE_LIMIT_PAGE_VIEWS')
                                ]
                            );
                        }
                        /** 
                         * If the user's IP has changed 
                         */
                        if (
                            !is_readable(PATH_TMP . self::getToken() . '.txt') &&
                            self::$session['user_ip'] != self::setUserIp()
                        ) {
                            // addSession
                            self::addSession();

                            self::standardCookieUpdate();
                            #
                        } else {
                            // updSession
                            self::standardSessionUpdate();

                            self::standardCookieUpdate();
                        }
                        #
                    } else {
                        // updSession
                        self::standardSessionUpdate();

                        self::standardCookieUpdate();
                    }
                }
            }

            if (self::getUserId() > 0) {
                DB::set(
                    "UPDATE `user` SET `latest_visit` = :latest_visit WHERE `id` = :id",
                    ['latest_visit' => time(), 'id' => self::getUserId()]
                );
            }
        }

        return self::$session;
    }

    private static function dieFunc(array $params)
    {
        /**
         * Save message about error to log
         */
        ToLog::blockCounter($params['file_line']);
        /**
         * Increase the number of views in a session by 1
         * Setting the editing time
         * Setting a new session lifetime
         * We write changes to the database
         */
        self::$session = self::updSession(
            [
                'views'         => self::$session['views'] + 1,
                'edited'        => time(),
                'block_counter' => self::$session['block_counter'] + 1,
                'enabled_to'    => time() + Config::getCfg('CFG_MIN_SESSION_TIME'),
            ]
        );

        self::setCookie(
            self::getSessionKey(),
            [
                'expires'  => time() + Config::getCfg('CFG_MIN_SESSION_TIME'),
                'path'     => '/',
                'secure'   => Config::getCfg('CFG_SECURE_COOKIE'),
                'httponly' => true,
                'samesite' => 'lax',
            ]
        );

        $v = array_merge(['lang' => self::$session['lang']], $params);

        ob_start();
        require PATH_TPL . 'die' . DS . 'die.php';
        echo ob_get_clean();

        die();
    }

    private static function standardSessionUpdate()
    {
        /**
         * Checking the time_difference field
         * If the field is NULL,
         * get the corresponding value from the cookie
         *
         * Increase the number of views in a session by 1
         * Setting the editing time
         * Setting a new session lifetime
         *
         * Recording changes to the database
         */
        return self::updSession(
            [
                'time_difference' => self::$session['time_difference'] === null ? self::setTimeDifference() : self::$session['time_difference'],
                'views'           => self::$session['views'] + 1,
                'edited'          => time(),
                'next_page_time'  => 1,
                'enabled_to'      => time() + self::getSessionTime(),
            ]
        );
    }

    private static function standardCookieUpdate()
    {
        return self::setCookie(self::getSessionKey());
    }

    private static function setCookie($sessionKey, $cookieOptions = null)
    {
        /**
         * Create or confirm cookies and extend their validity period
         */
        $cookieOptions = $cookieOptions !== null ? $cookieOptions : [
            'expires'  => time() + self::getSessionTime(),
            'path'     => '/',
            'secure'   => Config::getCfg('CFG_SECURE_COOKIE'),
            'httponly' => true,
            'samesite' => 'lax',
        ];

        setcookie('SESSION', $sessionKey, $cookieOptions);

        if (
            isset(GV::cookie()['messages_cookies']) &&
            GV::cookie()['messages_cookies'] == 'true'
        ) {
            $cookieOptions['expires'] = time() + Config::getCfg('CFG_MAX_SESSION_TIME');
            setcookie('messages_cookies', 'true', $cookieOptions);
        }

        if (
            !isset(GV::cookie()['ref_code']) &&
            isset(GV::get()['ref_code'])
        ) {
            $cookieOptions['expires'] = time() + 2629800;
            setcookie('ref_code', Clean::str(GV::get()['ref_code']), $cookieOptions);
        }
    }
    /**
     * Setting the session lifetime
     */
    private static function getSessionTime()
    {
        if (self::$sessionTime == 'null') {

            if (
                isset(self::$session['save_session']) &&
                is_string(self::$session['save_session']) &&
                self::$session['save_session'] === '1'
            ) {
                self::$sessionTime = Config::getCfg('CFG_MAX_SESSION_TIME'); // 14 days
            } else {
                self::$sessionTime = Config::getCfg('CFG_MIN_SESSION_TIME'); // 15 minutes
            }
        }

        return self::$sessionTime;
    }

    private static function getCountIp(): int
    {
        if (self::$countIp === 'null') {

            self::$countIp = (int) DB::getValue(
                "SELECT COUNT(session_key) FROM `session`
                WHERE `user_ip` = :user_ip AND `tmp_status` < :tmp_status",
                ['user_ip' => self::setUserIp(), 'tmp_status' => 1]
            );
        }

        return self::$countIp;
    }

    private static $setSessionKey = 'null';

    private static function setSessionKey()
    {
        if (self::$setSessionKey == 'null') {

            do {
                self::$setSessionKey = Randomizer::getRandomStr(32, 32);
                $session             = DB::getRow(
                    "SELECT * FROM `session` WHERE `session_key` = :session_key",
                    ['session_key' => self::$setSessionKey]
                );
            } while ($session !== false);
        }

        return self::$setSessionKey;
    }

    public static function getSessionKey()
    {
        if (isset(self::$session['session_key'])) {
            return self::$session['session_key'];
        } elseif (isset(GV::cookie()['SESSION'])) {
            return Clean::str(GV::cookie()['SESSION']);
        } else {
            return self::setSessionKey();
        }
    }

    private static function addSession(): array
    {
        self::$session = [
            'session_key'     => self::setSessionKey(),
            'token'           => self::setToken(),
            'user_ip'         => self::setUserIp(),
            'search_bots_ip'  => self::setSearchBotsIp(),
            'user_id'         => self::setUserId(),
            'time_difference' => self::setTimeDifference(),
            'tmp_status'      => self::setTmpStatus(),
            'lang'            => self::setLang(),
            'views'           => self::setViews(),
            'created'         => time(),
            'edited'          => time(),
            'next_page_time'  => self::setSearchBotsIp() === 1 ? 0 : 1,
            'block_counter'   => 0,
            'rtl'             => self::setRtl(),
            'save_session'    => self::setSaveSession(),
            'enabled_to'      => time() + self::getSessionTime(),
        ];

        $set = ParamsToSql::getSet(self::$session);

        DB::set(
            "INSERT INTO `session` SET $set",
            self::$session
        );

        return self::$session;
    }

    public static function updSession(array $array): array
    {
        /**
         * Getting the array keys in the array
         */
        $arrayKeys = array_keys($array);

        /**
         * Converting an array with keys into an SQL command
         * ...and assign them to the corresponding session keys
         * new values
         */
        $sql            = '';
        $countArrayKeys = count($arrayKeys);
        for ($i = 0; $i < $countArrayKeys; $i++) {
            $sql .= '`' . $arrayKeys[$i] . '` = :' . $arrayKeys[$i] . ', ';
            self::$session[$arrayKeys[$i]] = $array[$arrayKeys[$i]];
        }

        /**
         * Removing the last comma in an SQL query
         */
        $sql = substr(trim($sql), 0, -1);

        /**
         * Add the session key to the incoming array
         */
        $array['session_key'] = self::getSession()['session_key'];

        DB::set(
            "UPDATE `session`
            SET
            $sql
            WHERE `session_key` = :session_key",
            $array
        );

        return self::$session;
    }

    private static function delOldSession(): bool
    {
        return DB::set(
            "DELETE FROM `session`
            WHERE `enabled_to` < :enabled_to",
            ['enabled_to' => time()]
        );
    }

    private static function setToken(): string
    {
        return Randomizer::getRandomStr(32, 32);
    }

    public static function getToken(): string
    {
        return self::getSession()['token'];
    }

    private static function setUserIp(): string
    {
        $clientIP  = @GV::server()['HTTP_CLIENT_IP'];
        $forwardIP = @GV::server()['HTTP_X_FORWARDED_FOR'];
        $remoteIP  = @GV::server()['REMOTE_ADDR'];

        if (filter_var($clientIP, FILTER_VALIDATE_IP)) {
            return $clientIP;
        } elseif (filter_var($forwardIP, FILTER_VALIDATE_IP)) {
            return $forwardIP;
        } else {
            return $remoteIP;
        }
    }

    public static function getUserIp(): string
    {
        return isset(self::getSession()['user_ip']) ? self::getSession()['user_ip'] : self::setUserIp();
    }

    private static function setUserId(): int
    {
        return 0;
    }

    public static function getUserId(): int
    {
        return self::getSession()['user_id'];
    }

    private static function setViews()
    {
        return 1;
    }

    private static function setLang()
    {
        $langList  = Languages::langList();

        if (
            count($langList) > 1 &&
            isset(GV::server()['HTTP_ACCEPT_LANGUAGE'])
        ) {

            $usersLang = substr(GV::server()['HTTP_ACCEPT_LANGUAGE'], 0, 2);

            $lang = '';

            foreach ($langList as $key => $value) {
                if ($langList[$key][0] == $usersLang) {
                    $lang = $usersLang;
                    break;
                }
            }

            if ($lang == '') {
                return Languages::langList()[0][0];
            } else {
                return $lang;
            }
            #
        } else {
            return $langList[0][0];
        }
    }

    public static function getLang()
    {
        if (isset(self::getSession()['lang'])) {
            if (count(Languages::langList()) > 1) {
                return self::getSession()['lang'];
            } else {
                return self::setLang();
            }
        } else {
            return self::setLang();
        }
    }

    public static function getLangUpd(string $lang): string
    {
        if (Languages::checkLang($lang) === true) {

            DB::set(
                "UPDATE `session` SET `lang` = :lang WHERE `session_key` = :session_key",
                [
                    'lang'        => $lang,
                    'session_key' => self::getSession()['session_key'],
                ]
            );

            if (self::getUserId() !== 0) {
                DB::set(
                    "UPDATE `user` SET `lang` = :lang WHERE `id` = :id",
                    [
                        'lang' => $lang,
                        'id' => self::getUserId(),
                    ]
                );
            }

            return self::$session['lang'] = $lang;
        } else {
            return self::getSession()['lang'];
        }
    }

    private static function setRtl()
    {
        if (
            GV::get() !== null &&
            GV::get()['rtl']
        ) {
            $rtl = GV::get()['rtl'];
        } else {
            $usersLang     = substr(GV::server()['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $langList      = Languages::langList();
            $countLangList = count($langList);
            for ($i = 0; $i < $countLangList; $i++) {
                if ($langList[$i][0] == $usersLang && $langList[$i][3] == 1) {
                    $rtl = 1;
                    break;
                } else {
                    $rtl = 0;
                }
            }
        }
        return $rtl;
    }

    public static function getRtl()
    {
        if (isset(self::getSession()['rtl'])) {
            return self::getSession()['rtl'];
        } else {
            return self::setRtl();
        }
    }

    private static function setSaveSession()
    {
        if (
            GV::post() !== null ||
            (isset(GV::post()['save_session']) && GV::post()['save_session'] == 1)
        ) {
            return 1;
        } else {
            return 0;
        }
    }

    private static function setTmpStatus()
    {
        return -1;
    }

    public static function getTmpStatus()
    {
        return (int) self::getSession()['tmp_status'];
    }

    private static function setSearchBotsIp()
    {
        if (CheckSearchBotsIp::getIpAccess(self::setUserIp()) === true) {
            return 1; // search engine bot
        } else {
            return 0;
        }
    }

    public static function getSearchBotsIp(): int
    {
        return (int) self::getSession()['search_bots_ip'];
    }

    private static function setTimeDifference()
    {
        if (isset(GV::cookie()['time_difference'])) {

            $timeDifference = Clean::int(GV::cookie()['time_difference']);

            if (
                is_int($timeDifference) &&
                ($timeDifference > -60 &&
                    $timeDifference < 60
                )
            ) {
                return 0;
            } elseif (is_int($timeDifference)) {
                return floor($timeDifference / 60) * 60;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function getTimeDifference()
    {
        return self::getSession()['time_difference'];
    }
}
