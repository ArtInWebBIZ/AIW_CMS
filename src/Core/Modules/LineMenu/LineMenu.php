<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\LineMenu;

defined('AIW_CMS') or die;

class LineMenu
{
    private static $menuView = null;

    public static function getMenuView()
    {
        if (self::$menuView === null) {
            require PATH_MODULES . 'LineMenu' . DS . 'view.php';
        }

        return self::$menuView;
    }
}
