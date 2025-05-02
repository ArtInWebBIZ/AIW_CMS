<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Index;

defined('AIW_CMS') or die;

use Core\{Auth, Content};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Ssl;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content = Content::getDefaultValue();

        if (Auth::getUserId() === 0) {
            $this->content['redirect'] = Ssl::getLinkLang();
        } elseif (GroupAccess::check([1])) {
            $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . Auth::getUserId() . '.html';
        } elseif (GroupAccess::check([5])) {
            $this->content['redirect'] = Ssl::getLinkLang() . 'user/control/';
        }

        return $this->content;
    }
}
