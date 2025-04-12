<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */
defined('AIW_CMS') or die;

use Core\{Content, Session};
use App\Blog\View\Req\Func;
use Core\Plugins\Check\Item;
use Core\Plugins\Dll\ForAll;
use Core\Plugins\Ssl;

$getContent = Content::getDefaultValue();

$getContent['access'] = Func::getI()->checkAccess();
$getContent['tpl']    = 'index';

if (Func::getI()->checkAccess()) {

    if ((int) Func::getI()->checkItem()['status'] === ForAll::contentStatus()['ITEM_PUBLISHED']) {

        $getContent['canonical'] = ForAll::canonical(Func::getI()->checkItem()['def_lang']);
        $getContent['alternate'] = Item::getI()->itemAlternate(Func::getI()->checkItem()['def_lang']);

        if (Session::getLang() == Func::getI()->checkItem()['cur_lang']) {

            $getContent['robots']        = ForAll::robots();
            $getContent['sitemap_order'] = ForAll::sitemapOrder();
            #
        }
    }

    $getContent['meta']           = Item::getI()->pageMeta();
    $getContent['description']    = Func::getI()->checkItem()['description'];
    $getContent['keywords']       = Func::getI()->checkItem()['keywords'];
    $getContent['title']          = Func::getI()->checkItem()['heading'];
    $getContent['image']          = Ssl::getLink() . '/' . Item::getI()->getImgPath();
    $getContent['content']        = Func::getI()->itemView();
}


return $getContent;
