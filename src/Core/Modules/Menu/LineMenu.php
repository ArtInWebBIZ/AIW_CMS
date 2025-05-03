<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Modules\Menu;

defined('AIW_CMS') or die;

use Core\Plugins\Create\Menu\LineMenu as Line;

class LineMenu
{
    private static $menuView = null;

    public static function getMenuView()
    {
        if (self::$menuView === null) {
            self::$menuView = Line::getI()->createMenu(
                require PATH_INC . 'menu' . DS . 'mainLine.php'
            );
        }

        return self::$menuView;
    }
}
