<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Modules\LangMenu;

defined('AIW_CMS') or die;

use Core\Languages;
use Core\Modules\LangPageLinks;
use Core\Plugins\View\Tpl;

class LangMenu
{
    private static $menuView = null;

    public static function getMenuView()
    {
        if (
            self::$menuView === null &&
            count(Languages::langList()) > 1
        ) {
            self::$menuView =  Tpl::view(
                PATH_TPL . 'menu' . DS . 'lang' . DS . 'view.php',
                [
                    'lang_li' => LangPageLinks::renderLinks(),
                ]
            );
        }

        return self::$menuView;
    }
}
