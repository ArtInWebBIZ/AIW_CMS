<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\NewUser;

defined('AIW_CMS') or die;

use App\User\NewUser\Req\Func;
use Core\{Content, GV};
use Core\Plugins\{Ssl, Dll\User};

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['tpl']   = 'admin';
        $this->content['title'] = 'USER_ADD';

        User::getI()->deleteNotActivatedUsers();
        /**
         * Check user access
         */
        if (Func::getI()->checkAccess() === true) {
            /**
             * Check data in POST
             */
            if (GV::post() === null) {
                $this->content['content'] = Func::getI()->getAddUserForm();
            }
            /**
             * If POST is not null
             */
            else {
                $this->content = (new \App\User\NewUser\Req\Post)->getContent();
            }
        }
        /**
         * Else redirect to home page
         */
        else {
            $this->content['redirect'] = Ssl::getLinkLang();
        }

        return $this->content;
    }
}
