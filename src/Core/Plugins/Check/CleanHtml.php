<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\Plugins\Dll\ForAll;

class CleanHtml
{
    private static $allTags = null;
    /**
     * Return in array all enabled HTML tags
     * @return array
     */
    private static function allTags(): array
    {
        if (self::$allTags === null) {
            self::$allTags = ForAll::valueFromKey('default', 'htmlTags');
        }

        return self::$allTags;
    }
    /**
     * Return in string all enabled HTML tags
     * @return string
     */
    public static function allTagsInString(): string
    {
        return implode("", self::allTags());
    }
    /**
     * Return in string cleaned HTML
     * @param string|null $text
     * @return string
     */
    public static function cleanTags(string $text = null): string
    {
        $html = '';

        if ($text !== null) {

            $html    = $text;
            $allTags = self::allTags();

            foreach ($allTags as $key => $tag) {

                $tag = trim($tag, ">");
                $html = preg_replace(
                    '@' . $tag . '.*?>@si',
                    $tag . '>',
                    $html
                );
            }
            unset($allTags, $key, $tag);
        }

        return $html;
    }
}
