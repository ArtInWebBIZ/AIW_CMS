<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Create\Gallery;

defined('AIW_CMS') or die;

use Core\{Router};
use Core\Plugins\Check\Item;

class Gallery
{
    private static $instance = null;
    private $checkPath       = 'null';

    private function __construct() {}

    public static function getI(): Gallery
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Get gallery path
     * @return mixed // array or false
     */
    private function checkPath(): mixed
    {
        if ($this->checkPath == 'null') {

            $this->checkPath = [];

            if (
                Router::getRoute()['controller_url'] == 'doc' &&
                is_dir(PATH_PUBLIC . 'gallery' . DS . 'doc' . DS . Router::getPageAlias())
            ) {

                $this->checkPath['list'] = PATH_PUBLIC . 'gallery' . DS . 'doc' . DS . Router::getPageAlias();
                $this->checkPath['img']  = '/gallery/doc/' . Router::getPageAlias() . '/';
                #
            } elseif (is_array(Item::getI()->checkItem())) {

                if (
                    is_dir(PATH_PUBLIC . 'gallery' . DS .
                        date("Y", Item::getI()->checkItem()['created']) . DS .
                        date("m", Item::getI()->checkItem()['created']) . DS .
                        date("d", Item::getI()->checkItem()['created']) . DS .
                        Item::getI()->checkItem()['id'])
                ) {

                    $this->checkPath['list'] = PATH_PUBLIC . 'gallery' . DS .
                        date("Y", Item::getI()->checkItem()['created']) . DS .
                        date("m", Item::getI()->checkItem()['created']) . DS .
                        date("d", Item::getI()->checkItem()['created']) . DS .
                        Item::getI()->checkItem()['id'];

                    $this->checkPath['img']  = '/gallery/' .
                        date("Y", Item::getI()->checkItem()['created']) . '/' .
                        date("m", Item::getI()->checkItem()['created']) . '/' .
                        date("d", Item::getI()->checkItem()['created']) . '/' .
                        Item::getI()->checkItem()['id'] . '/';
                }
            }

            $this->checkPath = $this->checkPath === [] ? false : $this->checkPath;
        }

        return $this->checkPath;
    }
    /**
     * Get images list
     * @return mixed // array or false
     */
    private function getImagesList(): mixed
    {
        if (is_array($this->checkPath())) {

            $imgList = scandir($this->checkPath()['list']);

            foreach ($imgList as $key => $value) {

                if (
                    $value == '.' ||
                    $value == '..' ||
                    $value == 'thumb' ||
                    $value == 'index.html'
                ) {
                    unset($imgList[$key]);
                }
            }

            return $imgList;
            #
        } else {
            return false;
        }
    }
    #
    private $getGalleryHtml = 'null';
    /**
     * Return gallery html
     * @return string
     */
    public function getGalleryHtml(): string
    {
        if ($this->getGalleryHtml == 'null') {

            $this->getGalleryHtml = '';

            if (is_array($this->getImagesList())) {

                $this->getGalleryHtml .= '<div class="uk-child-width-1-2 uk-child-width-1-3@m uk-flex uk-flex-center uk-flex-wrap" uk-lightbox="animation: fade">';

                foreach ($this->getImagesList() as $key => $value) {
                    $this->getGalleryHtml .= '
                    <div>
                        <a class="uk-inline" href="' . $this->checkPath()['img'] . $value . '">
                            <img class="intro-image" src="' . $this->checkPath()['img'] . 'thumb/' . $value . '" width="480" height="480" alt="">
                        </a>
                    </div>';
                }

                $this->getGalleryHtml .= '</div>';
            }
        }

        return $this->getGalleryHtml;
    }
    /**
     * Return gallery from path
     * @return string
     */
    public function galleryFromPath(string $path): string
    {
        /**
         * Example <?= Gallery::getI()->galleryFromPath('/gallery/tour/20/01/') ?>
         */
        $preparePath = PATH_PUBLIC . str_replace("/", DS, $path);
        $imgList = [];
        $imgList = scandir($preparePath);

        if (is_array($imgList)) {

            foreach ($imgList as $key => $value) {

                if (
                    $value == '.' ||
                    $value == '..' ||
                    $value == 'thumb' ||
                    $value == 'index.html'
                ) {
                    unset($imgList[$key]);
                }
            }
            unset($key, $value);

            $galleryFromPath = '';

            $galleryFromPath .= '<div class="uk-child-width-1-2 uk-child-width-1-3@m uk-flex uk-flex-center uk-flex-wrap" uk-lightbox="animation: fade">';

            foreach ($imgList as $key => $value) {
                $galleryFromPath .= '
                        <div>
                            <a class="uk-inline" href="' . $path . $value . '">
                                <img class="intro-image" src="' . $path . 'thumb/' . $value . '" width="480" height="480" alt="">
                            </a>
                        </div>';
            }
            unset($key, $value);

            $galleryFromPath .= '</div>';

            return $galleryFromPath;
            #
        } else {
            return '';
        }
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
