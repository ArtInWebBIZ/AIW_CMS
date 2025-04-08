<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Plugins\Ssl;
use Core\{Router};

class PageMeta
{
    private static $getMeta = 'null';
    /**
     * Return corrects meta tags to item page
     * @return string
     */
    public static function getMeta(): string
    {
        if (self::$getMeta == 'null') {

            self::$getMeta = '';

            if (is_array(Item::getI()->checkItem())) {

                self::$getMeta .= '
    <meta itemprop="dateModified" content="' . metaDate(Item::getI()->checkItem()['edited']) . '">
    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="' . Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . Item::getI()->checkItem()['id'] . '.html' . '" />';
                #
            }
        }

        return self::$getMeta;
    }
    #
}
