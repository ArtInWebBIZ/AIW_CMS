<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Dll\ForAll;

$getContent = [];

$getContent['access']         = true;

$getContent['title']          = 'SERVICE_SERVICE';
$getContent['controller_url'] = 'blog';
$getContent['template_path']  = ForAll::contIncPath() . 'Blog' . DS . 'template.php';
$getContent['header_path']    = ForAll::contIncPath() . 'Blog' . DS . 'header.php';
$getContent['body_path']      = ForAll::contIncPath() . 'Blog' . DS . 'body.php';
$getContent['fields_in_body'] = ['id', 'def_lang', 'created'];
$getContent['lang_fields']    = ['heading', 'intro_img', 'intro_text'];
$getContent['self_order_by']  = false; // true or false
$getContent['order_by']       = 'DESC'; // or DESC
$getContent['extra_limit']    = 2; // or DESC
$getContent['extra']          = [
    // 'id' => [
    //     'value' => [9],
    // ],
    'status' => [
        'value' => ForAll::contentStatus('blog')['ITEM_PUBLISHED'],
    ],
];
$getContent['pagination']     = Config::getCfg('CFG_PAGINATION');

return $getContent;
