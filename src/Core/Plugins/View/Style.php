<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\View;

defined('AIW_CMS') or die;

class Style
{
    private static $content = null;
    private static $form    = null;
    private static $control = null;
    /**
     * Return styles to content block
     * @return array
     */
    public static function content(): array
    {
        if (self::$content == null) {
            self::$content = require PATH_INC . 'style' . DS . 'content.php';
        }

        return self::$content;
    }
    /**
     * Return styles to content block
     * @return array
     */
    public static function form(): array
    {
        if (self::$form === null) {
            self::$form = require PATH_INC . 'style' . DS . 'form.php';
        }

        return self::$form;
    }
    /**
     * Return styles to content block
     * @return array
     */
    public static function control(): array
    {
        if (self::$control == null) {
            self::$control = require PATH_INC . 'style' . DS . 'control.php';
        }

        return self::$control;
    }
}
