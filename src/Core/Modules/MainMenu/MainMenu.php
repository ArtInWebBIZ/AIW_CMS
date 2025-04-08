<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\MainMenu;

defined('AIW_CMS') or die;

use Core\Plugins\View\Tpl;

class MainMenu
{
    public static function getMenuView(): string
    {
        return Tpl::view(PATH_MODULES . 'MainMenu' . DS . 'view.php');
    }
}
