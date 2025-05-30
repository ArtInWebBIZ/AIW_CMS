<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\Blog\Lib\Fields;
use Core\{Config, Trl};
use Core\Plugins\Fields\Item;

$introImg             = Item::getI()->introImg(isset($v['intro_img']) ? $v['intro_img'] : '');
$introImg['required'] = false;
$introImg['info']     = Trl::sprintf('ITEM_HEADING_INFO', ...[
    Config::getCfg('CFG_MIN_HEADING_LEN'),
    Config::getCfg('CFG_MAX_HEADING_LEN'),
]);

return [
    'cur_lang'    => Item::getI()->curLang(isset($v['cur_lang']) ? $v['cur_lang'] : ''),
    'intro_img'   => $introImg,
    'heading'     => Item::getI()->heading(isset($v['heading']) ? $v['heading'] : ''),
    'keywords'    => Item::getI()->keywords(isset($v['keywords']) ? $v['keywords'] : ''),
    'description' => Item::getI()->description(isset($v['description']) ? $v['description'] : ''),
    'intro_text'  => Item::getI()->introText(isset($v['intro_text']) ? $v['intro_text'] : ''),
    'text'        => Item::getI()->text(isset($v['text']) ? $v['text'] : ''),
    'status'      => Fields::getI()->status(isset($v['status']) ? $v['status'] : ''),
    'self_order'  => Item::getI()->selfOrder(isset($v['self_order']) ? $v['self_order'] : ''),
];
