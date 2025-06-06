<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\View;

defined('AIW_CMS') or die;

use App\User\View\Req\Func;
use Comp\User\Lib\User;
use Core\{Auth, Content};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Check\IntPageAlias;

class Cont
{
    private $content = [];

    public function getContent()
    {
        User::getI()->deleteNotActivatedUsers();

        $this->content = Content::getDefaultValue();

        $this->content['tpl'] = GroupAccess::check([5]) ? 'admin' : 'index';

        if (Func::getI()->getViewedUser() !== false) {

            if (
                IntPageAlias::check() === Auth::getUserId() ||
                (
                    GroupAccess::check([5]) &&
                    Auth::getUserStatus() === 1
                )
            ) {
                $this->content['title'] = Func::getI()->getViewedUserFullName();
            } else {
                $this->content['title'] = Func::getI()->getViewedUserFullNameForAll();
            }
            /**
             * Check the permit for viewing the profile
             * this user
             */
            if (Func::getI()->checkAccess() === true) {
                $this->content['content'] .= Func::getI()->getViewViewedUser();
            } else {
                $this->content['content'] .= Func::getI()->getViewToAllUser();
            }
            #
        } else {
            /**
             * If such a profile does not exist
             */
            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
