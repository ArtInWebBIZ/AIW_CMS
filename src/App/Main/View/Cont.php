<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Main\View;

defined('AIW_CMS') or die;

use Core\Content;
use Core\Plugins\Ssl;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content = Content::getDefaultValue();

        $this->content['redirect'] = Ssl::getLinkLang();

        return $this->content;
    }
}
