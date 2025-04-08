<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\Control;

defined('AIW_CMS') or die;

use Core\Plugins\Dll\User;

class Cont
{
    public function getContent()
    {
        User::getI()->deleteNotActivatedUsers();

        return (new \Core\Modules\Control\Control)->getContent();
    }
}
