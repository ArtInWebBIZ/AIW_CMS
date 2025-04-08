<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\LangMenu;

defined('AIW_CMS') or die;

use Core\Languages;

class LangMenu
{
    private static $menuView = null;

    public static function getMenuView()
    {
        if (
            self::$menuView === null &&
            count(Languages::langList()) > 1
        ) {
            require PATH_MODULES . 'LangMenu' . DS . 'view.php';
        }

        return self::$menuView;
    }
}
