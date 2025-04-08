<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{App, Auth, BaseUrl, Config, GV, Session, Plugins\Ssl, Router};
use Core\Modules\View\MsgInTmp;
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\View\ViewLog;

$files = scandir(PATH_TMP);
unset($files[0], $files[1]);

if (count($files) > 0) {
    foreach ($files as $key => $value) {
        if (filemtime(PATH_TMP . $files[$key]) < time() - 600) {
            unlink(PATH_TMP . $files[$key]);
        }
    }
}

ob_start();
MsgInTmp::getWriteMsgFromTmp();
$msg = ob_get_clean();

$msg = App::content()['msg'] . $msg;

/**
 * If isset redirect link
 * and isset message
 */
if (
    App::content()['redirect'] != '' &&
    $msg != ''
) {
    MsgInTmp::saveMsgToTmp($msg);
    Session::updSession(['next_page_time' => 0]);

    header('Location: ' . App::content()['redirect']);
    header('Cookie: SESSION=' . Session::getSessionKey());
}
/**
 * If incorrect url
 */
elseif (
    BaseUrl::getFullUrl() != GV::server()['REQUEST_URI'] ||
    (GV::server()['REQUEST_SCHEME'] . '://') !== Config::getCfg('http_type')
) {

    if ($msg != '') {
        MsgInTmp::saveMsgToTmp($msg);
    }

    Session::updSession(['next_page_time' => 0]);

    header('Location: ' . Ssl::getLink() . BaseUrl::getFullUrl());
    header('Cookie: SESSION=' . Session::getSessionKey());
}
/**
 * Echo message
 */
elseif (
    App::content()['redirect'] == '' &&
    $msg !== ''
) {
    if (is_readable(PATH_TMP . trim(Session::getToken()) . '.txt')) {
        unlink(PATH_TMP . trim(Session::getToken()) . '.txt');
    }

    if (GroupAccess::managerGroups()) {
        ViewLog::saveToLog('view_management_log');
    } elseif (Session::getSearchBotsIp() === 1) {
        ViewLog::saveToLog('view_index_log');
    } else {
        ViewLog::saveToLog('view_log');
    }
}
/**
 * If empty message and isset redirect
 */
elseif (
    isset(App::content()['redirect']) &&
    App::content()['redirect'] != ''
) {
    Session::updSession(['next_page_time' => 0]);
    header('Location: ' . App::content()['redirect']);
    header('Cookie: SESSION=' . Session::getSessionKey());
}
/**
 * Save user page views to log
 */
else {
    if (GroupAccess::managerGroups()) {
        ViewLog::saveToLog('view_management_log');
    } elseif (Session::getSearchBotsIp() === 1) {
        ViewLog::saveToLog('view_index_log');
    } else {
        ViewLog::saveToLog('view_log');
    }
}
