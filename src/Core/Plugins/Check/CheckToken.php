<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\{Session, Clean, GV,};

class CheckToken
{
    /**
     * Check token
     * Return true or die this session
     * @return boolean
     */
    public static function checkToken(): bool
    {
        if (
            Clean::str(GV::post()['token']) == Session::getToken()
        ) {

            return true;
            #
        } else {

            $v = [
                'lang'    => Session::getLang(),
                'refresh' => 10,
                'title'   => 'DIE_ERROR_SESSION_TOKEN',
                'h3'      => 'DIE_ERROR_SESSION_TOKEN',
                'p'       => 'DIE_ERROR_SESSION_TOKEN_INFO',
            ];

            ob_start();
            require PATH_TPL . 'die' . DS . 'die.php';
            echo ob_get_clean();

            die();
        }
    }
}
