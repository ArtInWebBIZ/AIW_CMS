<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Item\View\Func;

class View
{
    public function getContent()
    {
        if (Func::getI()->checkAccess() === true) {
            return Func::getI()->itemParams();
        } else {
            return (new \App\Main\Page404\Cont)->getContent();
        }
    }
}
