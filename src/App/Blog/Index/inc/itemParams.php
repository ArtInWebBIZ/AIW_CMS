<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */


use Core\{Content, Config};
use App\Blog\Index\Req\Func;
use Core\Plugins\Lib\ForAll;

defined('AIW_CMS') or die;

$getContent = Content::getDefaultValue();

$getContent['access']         = Func::getI()->checkAccess();
$getContent['tpl']            = 'index';
$getContent['title']          = 'BLOG_BLOG';

$getContent['robots']        = ForAll::robots();
$getContent['canonical']     = ForAll::canonical();
$getContent['alternate']     = ForAll::alternate();
$getContent['sitemap_order'] = ForAll::sitemapOrder();

$getContent['template_path']  = ForAll::contIncPath() . 'template.php';
$getContent['header_path']    = ForAll::contIncPath() . 'header.php';
$getContent['body_path']      = ForAll::contIncPath() . 'body.php';
$getContent['fields_in_body'] = ['id', 'author_id', 'def_lang', 'created', 'edited', 'status'];
$getContent['lang_fields']    = ['heading', 'intro_img', 'intro_text'];
$getContent['order_by']       = 'DESC'; // or DESC
$getContent['extra']          = [
    'status' => [
        'value' => ForAll::compIncFile('Blog', 'status')['ITEM_PUBLISHED'],
    ]
];
$getContent['pagination']     = Config::getCfg('CFG_PAGINATION');

return $getContent;
