<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\Edit;

defined('AIW_CMS') or die;

use App\User\Edit\Req\Func;
use Core\{Content, GV, Router};
use Core\Plugins\{Dll\User, Msg, Ssl, Check\EditNote};
use Core\Plugins\Check\IntPageAlias;

class Cont
{
    private $content = [];

    public function getContent()
    {
        User::getI()->deleteNotActivatedUsers();

        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'USER_EDIT';
        /**
         * Check users access
         */
        if (Func::getI()->checkAccess() === true) {
            /**
             * Check user edit in this time
             */
            if (EditNote::getI()->checkNote() === true) {
                /**
                 * If $_POST is null
                 */
                if (GV::post() === null) {
                    $this->content['content'] = Func::getI()->viewForm();
                }
                /**
                 * If $_POST is not null
                 */
                else {
                    $this->content = (new Req\Post)->getContent();
                }
            }
            /**
             * If User edited in this time
             */
            else {
                $this->content['msg']     .= Msg::getMsg_('warning', 'USER_BEING_EDITED');
                $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . IntPageAlias::check() . '.html';
            }
        }
        /**
         * If Users is not access
         */
        else {
            /**
             * Redirect to user`s page
             */
            $this->content['redirect'] = Ssl::getLinkLang() . 'user/' . Router::getRoute()['page_alias'] . '.html';
        }

        return $this->content;
    }
}
