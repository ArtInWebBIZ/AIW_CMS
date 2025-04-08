<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\View;

defined('AIW_CMS') or die;

use Core\Session;

class MsgInTmp
{

    public static function getWriteMsgFromTmp()
    {
        return is_readable(PATH_TMP . trim(Session::getToken()) . '.txt') ? readfile(PATH_TMP . trim(Session::getToken()) . '.txt') : '';
    }

    public static function saveMsgToTmp($msg)
    {
        $fp = fopen(PATH_TMP . trim(Session::getToken()) . '.txt', 'w+');
        fwrite($fp, $msg);
        fclose($fp);

        return true;
    }
}
