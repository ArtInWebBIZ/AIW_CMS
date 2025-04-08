<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\SearchBotsIp\View;

defined('AIW_CMS') or die;

use Core\Content;

class Cont
{

    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = '';

        $this->content = (new \App\Main\NoAccess\Cont)->getContent();

        return $this->content;
    }
}
