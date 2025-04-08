<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Main\Index\Req;

use Core\Plugins\Check\Item;
use Core\Plugins\Dll\ForAll;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Tpl;
use Core\Session;

defined('AIW_CMS') or die;

class Func
{
    private static $instance = null;
    private $fastExcursion = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function checkAccess()
    {
        return true;
    }
    /**
     * Return …
     * @return string
     */
    public function fastExcursion(): string
    {
        if ($this->fastExcursion == 'null') {

            $this->fastExcursion = Excursion::getI()->fastExcursion();
        }

        return $this->fastExcursion;
    }
    /**
     * Return …
     * @return string
     */
    public function viewLatestReviews(): string
    {
        return Review::getI()->viewLatestReviews();
    }
    #
    private $viewLatestBlog = 'null';
    /**
     * Return in string correct values from traditional html file
     * and php data injection
     * @return string
     */
    public function viewLatestBlog(): string
    {
        if ($this->viewLatestBlog === 'null') {

            $this->viewLatestBlog = Tpl::view(
                ForAll::contIncPath() . 'blog.php',
                ['blog' => $this->latestBlogHtml()]
            );
        }

        return $this->viewLatestBlog;
    }
    #
    private $latestBlogHtml = 'null';
    /**
     * Return …
     * @return string
     */
    private function latestBlogHtml(): string
    {
        if ($this->latestBlogHtml === 'null') {

            $this->latestBlogHtml = '';

            if ($this->getLatestBlog() != []) {

                foreach ($this->getLatestBlog() as $key => $value) {

                    $v = [
                        'created'    => $value['created'],
                        'title'      => $value['title'],
                        'intro_img'  => $value['intro_img'],
                        'intro_text' => $value['intro_text'],
                        'id'         => $value['id'],
                    ];

                    $this->latestBlogHtml .= Tpl::view(ForAll::contIncPath() . 'blogBody.php', $v);
                }
            }
        }

        return $this->latestBlogHtml;
    }
    #
    private $getLatestBlog = null;
    /**
     * Return latest blog in array or []
     * @return array
     */
    private function getLatestBlog(): array
    {
        if ($this->getLatestBlog == null) {

            $getLatestBlog = DB::getI()->getNeededField(
                [
                    'table_name'          => 'item',
                    'field_name'          => 'id`,`def_lang`,`created', // example 'id' or 'id`,`edited_count`,`brand_status'
                    'where'               => ParamsToSql::getSql(
                        $where = [
                            'item_controller_id' => 1,
                            'status' => 2
                        ]
                    ),
                    'array'               => $where,
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => 'DESC', // DESC
                    'offset'              => 0,
                    'limit'               => 3, // 0 - unlimited
                ]
            );

            if ($getLatestBlog != []) {

                $getItemsId = [];

                foreach ($getLatestBlog as $key => $value) {
                    $getItemsId[$key] = $getLatestBlog[$key]['id'];
                }

                $itemsLang = $this->getItemsLang($getItemsId);

                if (count($itemsLang) < count($getLatestBlog)) {
                    foreach ($getLatestBlog as $key => $value) {
                        $lang = false;
                        foreach ($itemsLang as $key1 => $value1) {
                            if ($itemsLang[$key1]['item_id'] == $getLatestBlog[$key]['id']) {
                                $lang = true;
                                $getLatestBlog[$key] = array_merge($getLatestBlog[$key], $itemsLang[$key1]);
                                unset($getLatestBlog[$key]['item_id']);
                                break;
                            }
                        }
                        if ($lang === false) {

                            $lang = $this->getItemsLang([$getLatestBlog[$key]['id']], $getLatestBlog[$key]['def_lang']);

                            $getLatestBlog[$key] = array_merge($getLatestBlog[$key], $lang[0]);
                            unset($getLatestBlog[$key]['item_id']);
                        }
                    }
                    unset($key, $value);
                    unset($key1, $value1);
                    #
                } else {
                    foreach ($getLatestBlog as $key => $value) {
                        foreach ($itemsLang as $key1 => $value1) {
                            if ($itemsLang[$key1]['item_id'] == $getLatestBlog[$key]['id']) {
                                $getLatestBlog[$key] = array_merge($getLatestBlog[$key], $itemsLang[$key1]);
                                unset($itemsLang[$key1]);
                                unset($getLatestBlog[$key]['item_id']);
                            }
                        }
                    }
                    unset($key, $value);
                    unset($key1, $value1);
                }
            }

            $this->getLatestBlog = $getLatestBlog;
        }

        return $this->getLatestBlog;
    }
    #
    private $getExcursionItems = null;
    /**
     * Return excursion items array
     * @return array // array or []
     */
    private function getExcursionItems(): array
    {
        if ($this->getExcursionItems == null) {

            $itemsId = require ForAll::contIncPath() . 'excursionsId.php';

            if ($itemsId != []) {

                $items = $this->getMergeItemsAndLang(
                    $this->getItems($itemsId),
                    $this->getItemsLang($itemsId)
                );

                $in = ParamsToSql::getInSql($itemsId);

                $filters = DB::getI()->getNeededField(
                    [
                        'table_name'          => 'item_excursion',
                        'field_name'          => 'item_id`,`transport`,`length`,`price_3`,`price_6`,`price_group',
                        'where'               => '`item_id`' . $in['in'],
                        'array'               => $in['array'],
                        'order_by_field_name' => 'item_id',
                        'order_by_direction'  => 'ASC',
                        'offset'              => 0,
                        'limit'               => count($itemsId),
                    ]
                );

                foreach ($items as $key => $value) {
                    foreach ($filters as $key1 => $value1) {
                        if ($filters[$key1]['item_id'] == $items[$key]['id']) {
                            $items[$key] = array_merge($items[$key], $filters[$key1]);
                        }
                    }
                    unset($items[$key]['item_id']);
                    $items[$key]['from_place'] = $this->getFieldset('from_place', $items[$key]['id']);
                    $items[$key]['place']      = $this->getFieldset('place', $items[$key]['id']);
                }
                unset($key, $value);
                unset($key1, $value1);

                $this->getExcursionItems = $items;
                #
            } else {
                $this->getExcursionItems = [];
            }
        }

        return $this->getExcursionItems;
    }
    #
    private $getTourItems = null;
    /**
     * Return excursion items array
     * @return array // array or []
     */
    private function getTourItems(): array
    {
        if ($this->getTourItems == null) {

            $itemsId = require ForAll::contIncPath() . 'tourId.php';

            if ($itemsId != []) {

                $items = $this->getMergeItemsAndLang(
                    $this->getItems($itemsId),
                    $this->getItemsLang($itemsId)
                );

                $in = ParamsToSql::getInSql($itemsId);

                $filters = DB::getI()->getNeededField(
                    [
                        'table_name'          => 'item_tour',
                        'field_name'          => 'item_id`,`transport`,`length`,`price_3`,`price_6`,`price_group',
                        'where'               => '`item_id`' . $in['in'],
                        'array'               => $in['array'],
                        'order_by_field_name' => 'item_id',
                        'order_by_direction'  => 'ASC',
                        'offset'              => 0,
                        'limit'               => count($itemsId),
                    ]
                );

                foreach ($items as $key => $value) {
                    foreach ($filters as $key1 => $value1) {
                        if ($filters[$key1]['item_id'] == $items[$key]['id']) {
                            $items[$key] = array_merge($items[$key], $filters[$key1]);
                        }
                    }
                    unset($items[$key]['item_id']);
                    $items[$key]['from_place'] = $this->getFieldset('from_place', $items[$key]['id']);
                    $items[$key]['place']      = $this->getFieldset('place', $items[$key]['id']);
                }
                unset($key, $value);
                unset($key1, $value1);

                $this->getTourItems = $items;
                #
            } else {
                $this->getTourItems = [];
            }
        }

        return $this->getTourItems;
    }
    #
    public function fastTour(): string
    {
        if ($this->fastTourBody() != '') {

            return Tpl::view(
                ForAll::contIncPath() . 'tour.php',
                [
                    'body' => $this->fastTourBody(),
                ]
            );
            #
        } else {
            return '';
        }
    }
    #
    private function fastTourBody(): string
    {
        $getTourItems = $this->getTourItems();

        if ($getTourItems != []) {

            $body       = '';
            $introImage = '';

            foreach ($getTourItems as $key => $value) {

                $introImage = Item::getI()->getItemImgPath(
                    $value['created'],
                    $value['id'],
                    $value['intro_img'],
                );

                $v = [
                    'id'          => $value['id'],
                    'intro_image' => $introImage,
                    'title'       => $value['title'],
                    'from_place'  => $value['from_place'],
                    'transport'   => $value['transport'],
                    'length'      => $value['length'],
                    'place'       => $value['place'],
                    'price_3'     => $value['price_3'],
                    'price_6'     => $value['price_6'],
                    'price_group' => $value['price_group'],
                ];

                $body .= require ForAll::contIncPath() . 'tourBody.php';
            }

            return $body;
            #
        } else {
            return '';
        }
    }
    #    
    private $getItems = null;
    /**
     * Return get needed items
     * @return array
     */
    private function getItems(mixed $itemsId = ''): array
    {
        if ($itemsId == '') {

            return $this->getItems;
            #
        } elseif (
            $this->getItems == null ||
            is_array($itemsId)
        ) {

            if (count($itemsId) > 0) {

                $in = ParamsToSql::getInSql($itemsId);

                $this->getItems = DB::getI()->getNeededField(
                    [
                        'table_name'          => 'item',
                        'field_name'          => 'id`,`def_lang`,`created',
                        'where'               => '`id`' . $in['in'],
                        'array'               => $in['array'],
                        'order_by_field_name' => 'id',
                        'order_by_direction'  => 'ASC', // DESC
                        'offset'              => 0,
                        'limit'               => 0, // 0 - unlimited
                    ]
                );
                #
            } else {
                $this->getItems = [];
            }

            return $this->getItems;
            #
        } else {

            return $this->getItems;
            #
        }
    }
    #
    private function getItemsLang(array $itemsId, string $lang = 'lang'): array
    {
        $lang = $lang == 'lang' ? Session::getLang() : $lang;
        /**
         * Get lang items
         */
        $in = ParamsToSql::getInSql($itemsId);

        return DB::getI()->getNeededField(
            [
                'table_name'          => 'item_lang',
                'field_name'          => 'item_id`,`lang`,`title`,`intro_img`,`intro_text',
                'where'               => '`cur_lang` = :cur_lang AND `item_id`' . $in['in'],
                'array'               => array_merge(['lang' => $lang], $in['array']),
                'order_by_field_name' => 'id',
                'order_by_direction'  => 'DESC',
                'offset'              => 0,
                'limit'               => count($itemsId),
            ]
        );
    }
    #
    public function viewAboutUs()
    {
        $text = Tpl::view(
            PATH_APP . 'Main' . DS . 'Index' . DS . 'about' . DS . Session::getLang() . '.php',
        );

        return Tpl::view(
            ForAll::contIncPath() . 'about.php',
            [
                'text' => $text,
            ]
        );
    }
    #
    private function getMergeItemsAndLang(array $items, array $itemsLang): array
    {
        if (count($itemsLang) < count($items)) {
            foreach ($items as $key => $value) {
                $lang = false;
                foreach ($itemsLang as $key1 => $value1) {
                    if ($itemsLang[$key1]['item_id'] == $items[$key]['id']) {
                        $lang = true;
                        $items[$key] = array_merge($items[$key], $itemsLang[$key1]);
                        break;
                    }
                }
                if ($lang == false) {
                    $lang = $this->getItemsLang([$items[$key]['id']], $items[$key]['def_lang']);
                    $items[$key] = array_merge($items[$key], $lang[0]);
                }
                if (isset($items[$key]['item_id'])) {
                    unset($items[$key]['item_id']);
                }
            }
            unset($key, $value);
            unset($key1, $value1);
            return $items;
        } else {
            foreach ($items as $key => $value) {
                foreach ($itemsLang as $key1 => $value1) {
                    if ($itemsLang[$key1]['item_id'] == $items[$key]['id']) {
                        $items[$key] = array_merge($items[$key], $itemsLang[$key1]);
                        unset($itemsLang[$key1]);
                    }
                }
            }
            return $items;
        }
    }
    #
    private function getFieldset(string $fieldName, int $itemId): array
    {
        return DB::getI()->getColumn(
            [
                'table_name'           => 'item_' . $fieldName,
                'field_name'           => $fieldName,
                'where'                => ParamsToSql::getSql(
                    $where = ['item_id' => $itemId]
                ),
                'order_by_field_name'  => 'id',
                'order_by_direction'   => 'ASC',
                'offset'               => 0,
                'limit'                => 0,
                'array'                => $where,
            ]
        );
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
