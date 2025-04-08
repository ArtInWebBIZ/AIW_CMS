<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Ticket\Index;

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
        } elseif (GroupAccess::check([2])) {
            $this->content['redirect'] = Ssl::getLinkLang() . 'ticket/my/';
        } elseif (GroupAccess::check([5])) {
            $this->content['redirect'] = Ssl::getLinkLang() . 'ticket/control/';
        } else {
            $this->content['redirect'] = Ssl::getLinkLang();
        }

        return $this->content;
    }
}
