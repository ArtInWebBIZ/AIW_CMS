<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Item\ControlToCont\Func;

class ControlToCont
{
    public function getContent(string $dirName = null): string
    {
        if (Func::getI()->checkAccess($dirName) === true) {
            return Func::getI()->getContent()['content'];
        } else {
            return '';
        }
    }
}
