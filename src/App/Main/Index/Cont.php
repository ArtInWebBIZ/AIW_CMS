<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Main\Index;

defined('AIW_CMS') or die;

use App\Main\Index\Req\Func;
use Core\Content;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Tpl;

class Cont
{
    private $content = [];

    public function getContent()
    {
        if (Func::getI()->checkAccess() === true) {

            $this->content          = Content::getDefaultValue();
            $this->content['title'] = 'OV_HOME';

            $this->content['robots']        = ForAll::robots();
            $this->content['canonical']     = ForAll::canonical();
            $this->content['alternate']     = ForAll::alternate();
            $this->content['sitemap_order'] = ForAll::sitemapOrder();

            $this->content['content'] .= Tpl::view(ForAll::contIncPath() . 'slider.php');
            $this->content['content'] .= Tpl::view(ForAll::contIncPath() . 'about.php');
            $this->content['content'] .= Tpl::view(ForAll::contIncPath() . 'whyAreWe.php');
            $this->content['content'] .= Tpl::view(ForAll::contIncPath() . 'index.php');
        } else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
