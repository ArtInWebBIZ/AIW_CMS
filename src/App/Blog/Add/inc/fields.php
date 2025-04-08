<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Fields\Item;

return [
    'cur_lang'    => Item::getI()->curLang(isset($v['cur_lang']) ? $v['cur_lang'] : ''),
    'intro_img'   => Item::getI()->introImg(isset($v['intro_img']) ? $v['intro_img'] : ''),
    'heading'     => Item::getI()->heading(isset($v['heading']) ? $v['heading'] : ''),
    'keywords'    => Item::getI()->keywords(isset($v['keywords']) ? $v['keywords'] : ''),
    'description' => Item::getI()->description(isset($v['description']) ? $v['description'] : ''),
    'intro_text'  => Item::getI()->introText(isset($v['intro_text']) ? $v['intro_text'] : ''),
    'text'        => Item::getI()->text(isset($v['text']) ? $v['text'] : ''),
    'self_order'  => Item::getI()->selfOrder(isset($v['self_order']) ? $v['self_order'] : ''),
];
