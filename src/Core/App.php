<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\Plugins\View\Render;
use Core\Router;

class App
{
    private static $contentObj = null;
    private static $content    = [];

    private static function contentObj()
    {
        if (self::$contentObj === null) {
            $path = '\\App\\' . Router::getRoute()['controller_name'] . '\\' . Router::getRoute()['action_name'] . '\\Cont';
            self::$contentObj = (new $path);
        }

        return self::$contentObj;
    }

    public static function content()
    {
        if (self::$content == []) {
            self::$content = self::contentObj()->getContent();
        }

        return self::$content;
    }

    public static function render(): void
    {
        Render::getI()->render();
    }
}
