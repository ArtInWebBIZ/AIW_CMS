<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\Plugins\Create\Gallery\Gallery;
use Core\Plugins\View\Tpl;
use Core\Session;

class Content
{
    private static $contentDefault = null;
    private static $contentDoc     = null;

    public static function getDefaultValue()
    {
        return self::$contentDefault = self::$contentDefault === null ?
            require_once PATH_INC . 'content' . DS . 'content.php' :
            self::$contentDefault;
    }

    public static function complete(string $key, string $value)
    {
        self::$contentDefault[$key] = self::$contentDefault[$key] . $value;
        return self::$contentDefault;
    }

    public static function getContentStart(
        string $sectionCss   = '',
        string $containerCss = 'uk-container-small uk-padding',
        string $overflow     = ' overflow-hidden',
        string $sectionId    = '',
        string $sectionStyle = '',
    ): string {

        return Tpl::view(
            PATH_INC . 'content' . DS . 'content_start.php',
            [
                'section_id'    => $sectionId == '' ? '' : ' id="' . $sectionId . '"',
                'section_css'   => $sectionCss,
                'section_style' => $sectionStyle == '' ? '' : ' style="' . $sectionStyle . '"',
                'container_css' => $containerCss,
                'overflow_css'  => $overflow,
            ]
        );
    }

    public static function getFormStart(
        string $sectionCss  = '',
        string $containerCss = 'uk-padding',
        string $overflow       = ' overflow-hidden'
    ): string {

        return Tpl::view(
            PATH_INC . 'content' . DS . 'content_start.php',
            [
                'section_css'   => $sectionCss,
                'container_css' => 'uk-container-xsmall ' . $containerCss,
                'overflow_css'  => $overflow,
            ]
        );
    }

    public static function getContentEnd(): string
    {
        return Tpl::view(PATH_INC . 'content' . DS . 'content_end.php');
    }

    /**
     * Function getDocContent
     * @param string $fileName
     * @return string
     */
    public static function getDocContent(string $fileName): string
    {
        if (self::$contentDoc === null) {
            self::$contentDoc = self::getContentStart(
                '',
                'uk-container-small uk-padding',
                ' overflow-hidden',
                ''
            );
            self::$contentDoc .= Tpl::view(
                PATH_DOC . 'lang' . DS . Session::getLang() . DS . $fileName . '.php'
            );
            self::$contentDoc .= Gallery::getI()->getGalleryHtml();
            self::$contentDoc .= self::getContentEnd();
        }

        return self::$contentDoc;
    }
}
