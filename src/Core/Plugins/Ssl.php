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

    public static function getLinkLang()
    {
        if (self::$startLinkLang == '') {
            self::$startLinkLang = mb_strtolower(Config::getCfg('http_type')) . Config::getCfg('site_host') . BaseUrl::getLangToLink();
        }
        return self::$startLinkLang;
    }

    public static function getLink()
    {
        if (self::$startLink == '') {
            self::$startLink = mb_strtolower(Config::getCfg('http_type')) . Config::getCfg('site_host');
        }
        return self::$startLink;
    }
}
