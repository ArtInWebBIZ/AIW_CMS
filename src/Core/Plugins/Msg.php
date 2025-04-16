<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins;

defined('AIW_CMS') or die;

use Core\Modules\Msg as Message;
use Core\Trl;

class Msg
{
    public static function getMsg_($msgType, $msgText): string
    {
        return Message::getI()->getMsg($msgType, Trl::_($msgText));
    }

    public static function getMsgSprintf($msgType, $msgText, ...$args): string
    {
        return Message::getI()->getMsg($msgType, Trl::sprintf($msgText, ...$args));
    }
}
