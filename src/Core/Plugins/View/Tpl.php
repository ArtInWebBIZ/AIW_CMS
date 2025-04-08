<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\View;

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
            return 'Incorrect file ' . $path;
        }
    }
}
