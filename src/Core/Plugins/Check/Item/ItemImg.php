<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Check\Item;
use Core\Config;

class ItemImg
{
    private static $getImgPath = 'null';
    /**
     * Return full path (an image name) current items intro image
     * @return string
     */
    public static function getImgPath(): string
    {
        if (self::$getImgPath == 'null') {

            if (Item::getI()->checkItem() !== false) {

                self::$getImgPath = self::getItemImgPath(
                    Item::getI()->checkItem()['created'],
                    Item::getI()->checkItem()['id'],
                    Item::getI()->checkItem()['intro_img']
                );
                #
            } else {
                self::$getImgPath = '';
            }
        }

        return self::$getImgPath;
    }
    /**
     * Return full path (an image name) for item intro image
     * @return string
     */
    public static function getItemImgPath(int $created, int $itemId, string $imageName): string
    {
        return '/' . Config::getCfg('CFG_INTRO_IMAGE_PATH') . '/' .
            date("Y", $created) . '/' .
            date("m", $created) . '/' .
            date("d", $created) . '/' .
            $itemId . '/' . $imageName;
    }
}
