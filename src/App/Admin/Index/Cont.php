<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Admin\Index;

defined('AIW_CMS') or die;

use Core\Content;
use App\Admin\Index\Req\Func;
use Core\Plugins\Ssl;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content        = Content::getDefaultValue();
        $this->content['tpl'] = 'index';

        if (Func::getI()->checkAccess() === true) {
            $this->content['redirect'] = Ssl::getLinkLang() . 'admin/compare-unique-symbols/';
        } else {
            $this->content = (new \App\Main\Page404\Cont)->getContent();
        }

        return $this->content;
    }
}
