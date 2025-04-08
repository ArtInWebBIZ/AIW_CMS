<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Main\Page404;

defined('AIW_CMS') or die;

use Core\Content;

class Cont
{
    private $content = [];

    public function getContent()
    {

        $this->content          = Content::getDefaultValue();
        $this->content['tpl']   = 'page404';
        $this->content['title'] = 'OV_PAGE404';

        #:TODO

        return $this->content;
    }
}
