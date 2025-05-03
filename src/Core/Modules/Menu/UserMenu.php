<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Modules\Menu;

defined('AIW_CMS') or die;

use Core\Plugins\View\Tpl;

class UserMenu
{
    public static function getMenuView(): string
    {
        return Tpl::view(PATH_TPL . 'menu' . DS . 'user' . DS . 'view.php');
    }
}
