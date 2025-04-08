<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules;

defined('AIW_CMS') or die;

use Core\{BaseUrl, Languages, Session};

class LangPageLinks
{
    private static $renderLinks      = '';
    /**
     * Return all website languages links
     * @return string
     */
    public static function renderLinks(): string
    {
        $languageCodeList = Languages::langList();

        foreach ($languageCodeList as $key => $value) {

            $lang       = $languageCodeList[$key][0];
            $link       = BaseUrl::getLangPageUrl($lang);
            $langNative = $languageCodeList[$key][2];

            if ($lang == Session::getLang()) {
                $activeClass = ' class="uk-active"';
            } else {
                $activeClass = '';
            }

            self::$renderLinks .= '
            <li class="uk-text-uppercase"><a' . $activeClass . ' href="' . $link . '">' . $langNative . '</a></li>';
        }
        unset($key, $value);

        return self::$renderLinks;
    }
}
