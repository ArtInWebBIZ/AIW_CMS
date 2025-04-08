<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins;

defined('AIW_CMS') or die;

use Core\{BaseUrl, Config};

class Ssl
{
    private static $startLink     = '';
    private static $startLinkLang = '';
    /**
     * Get all website domain link and language initial value
     * @return string
     */
    public static function getLinkLang(): string
    {
        if (self::$startLinkLang === '') {
            self::$startLinkLang = mb_strtolower(Config::getCfg('http_type')) . Config::getCfg('site_host') . BaseUrl::getLangToLink();
        }
        return self::$startLinkLang;
    }
    /**
     * Get all website domain link without language initial value
     * @return string
     */
    public static function getLink(): string
    {
        if (self::$startLink === '') {
            self::$startLink = mb_strtolower(Config::getCfg('http_type')) . Config::getCfg('site_host');
        }
        return self::$startLink;
    }
}
