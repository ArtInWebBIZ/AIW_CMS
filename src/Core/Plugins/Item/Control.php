<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Item\Control\Func;

class Control
{
    public function getContent()
    {
        if (Func::getI()->checkAccess() === true) {
            return Func::getI()->getContent();
        } else {
            return (new \App\Main\NoAccess\Cont)->getContent();
        }
    }
}
