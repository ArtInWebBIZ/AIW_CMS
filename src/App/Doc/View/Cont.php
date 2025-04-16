<?php

/**
 * @ge    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Doc\View;

defined('AIW_CMS') or die;

use App\Doc\View\Req\Func;
use Core\Content;
use Core\Plugins\Dll\ForAll;

class Cont
{
    private $content = [];

    public function getContent()
    {
        if (Func::getI()->checkAccess() === true) {

            $this->content           = Content::getDefaultValue();
            $this->content['title']  = Func::getI()->viewDoc()['title'];

            $this->content['robots']        = ForAll::robots();
            $this->content['canonical']     = ForAll::canonical();
            $this->content['alternate']     = ForAll::alternate();
            $this->content['sitemap_order'] = ForAll::sitemapOrder();

            $this->content['content'] .= Func::getI()->viewDoc()['content'];
            #
        } else {

            $this->content = (new \App\Main\Page404\Cont)->getContent();
            #
        }

        return $this->content;
    }
}
