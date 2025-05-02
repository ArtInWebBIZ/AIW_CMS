<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Doc\Index;

defined('AIW_CMS') or die;

use App\Doc\Index\Req\Func;
use Core\{Content, Plugins\Ssl};

class Cont
{

    private $content = [];

    public function getContent()
    {

        if (Func::getI()->checkAccess() === true) {

            $this->content = Content::getDefaultValue();

            $this->content['redirect'] = Ssl::getLinkLang() . 'doc/about-us.html';
            #
        } else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
