<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\View;

defined('AIW_CMS') or die;

use App\User\View\Req\Func;
use Core\{Auth, Content};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Check\IntPageAlias;
use Core\Plugins\Dll\User;

class Cont
{
    private $content = [];

    public function getContent()
    {
        User::getI()->deleteNotActivatedUsers();

        $this->content = Content::getDefaultValue();

        $this->content['tpl'] = GroupAccess::check([2, 5]) ? 'admin' : 'index';

        if (Func::getI()->getViewedUser() !== false) {

            if (
                IntPageAlias::check() === Auth::getUserId() ||
                (GroupAccess::check([2, 5]) && Auth::getUserStatus() === 1)
            ) {
                $this->content['title'] = Func::getI()->getViewedUserFullName();
            } else {
                $this->content['title'] = Func::getI()->getViewedUserFullNameForAll();
            }
            /**
             * Проверяем разрешение просмотра профиля
             * этого пользователя
             */
            if (Func::getI()->checkAccess() === true) {
                $this->content['content'] .= Func::getI()->getViewViewedUser();
            } else {
                $this->content['content'] .= Func::getI()->getViewToAllUser();
            }
            #
        } else {
            /**
             * Если такого профиля не существует
             */
            $this->content = (new \App\Main\Page404\Cont)->getContent();
        }

        return $this->content;
    }
}
