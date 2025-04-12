<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Main\NoAccess;

defined('AIW_CMS') or die;

use Core\Content;

class Cont
{

    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'OV_NO_ACCESS';
        $this->content['tpl']   = 'noAccess';

        return $this->content;
    }
}
