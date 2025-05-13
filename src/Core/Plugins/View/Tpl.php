<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\View;

use Core\Config;

defined('AIW_CMS') or die;

class Tpl
{
    /**
     * Return in string correct values from traditional html file
     * and php data injection
     * @return string
     */
    public static function view(string $path, array $v = []): string
    {
        if (file_exists($path)) {

            ob_start();
            require $path;
            return ob_get_clean();
            #
        } else {
            if (Config::getCfg('CFG_DEBUG') === true) {
                return 'Incorrect file ' . $path;
            } else {
                return '';
            }
        }
    }
}
