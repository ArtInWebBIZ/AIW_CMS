<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Admin\FindUniqueSymbols;

defined('AIW_CMS') or die;

use App\Admin\FindUniqueSymbols\Req\Func;
use Core\Content;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['tpl']   = 'admin';
        $this->content['title'] = 'ADMIN_FIND_UNIQUE_SYMBOLS';

        if (Func::getI()->checkAccess() === true) {

            $this->content['content'] = Func::getI()->view();
            #
        } else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
            #
        }

        return $this->content;
    }
}
