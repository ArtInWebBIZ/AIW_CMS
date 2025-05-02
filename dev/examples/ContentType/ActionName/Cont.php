<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ContentType\ActionName;

defined('AIW_CMS') or die;

use App\ContentType\ActionName\Req\Func;
use Core\Content;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'EXAMPLE_PAGE_TITLE';

        if (Func::getI()->checkAccess() === true) {

            #:TODO

        } else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
            #
        }

        return $this->content;
    }
}
