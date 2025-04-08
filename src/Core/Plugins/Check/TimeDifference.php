<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\Plugins\View\Tpl;

class TimeDifference
{
    public static function viewScript()
    {
        return Tpl::view(PATH_INC . 'session' . DS . 'timeDifference.php', []);
    }
}
