<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Control;

defined('AIW_CMS') or die;

use Comp\User\Lib\User;

class Cont
{
    public function getContent()
    {
        User::getI()->deleteNotActivatedUsers();

        return (new \Core\Modules\Control\Control)->getContent();
    }
}
