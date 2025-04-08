<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\{BaseUrl, Languages};
use Core\Plugins\Check\Item;
use Core\Plugins\Ssl;

class Alternate
{
    /**
     * Return meta link alternate for items content type
     * @return string
     */
    public static function getItemAlternate(): string
    {
        $link = '';

        if (count(Languages::langList()) > 1) {

            if (
                is_array(Item::getI()->checkItem()) &&
                count(Item::getI()->getAllItemsCurLang()) > 0
            ) {
                foreach (Item::getI()->getAllItemsCurLang() as $key => $value) {
                    $link .= '<link rel="alternate" hreflang="' . $value . '" href="' . Ssl::getLink() . '/' . $value . '/' . BaseUrl::getOnlyUrl() . '" />';
                }

                $link .= '<link rel="alternate" hreflang="x-default" href="' . Ssl::getLink() . '/' . Item::getI()->checkItem()['def_lang'] . '/' . BaseUrl::getOnlyUrl() . '" />';
            }
            #
        }

        return $link;
    }
}
