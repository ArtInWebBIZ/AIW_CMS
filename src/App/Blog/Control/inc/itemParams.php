<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Content, Config};
use App\Blog\Control\Req\Func;
use Core\Plugins\Dll\ForAll;

$getContent = Content::getDefaultValue();

$getContent['access']         = Func::getI()->checkAccess();
$getContent['tpl']            = 'admin';
$getContent['title']          = 'BLOG_CONTROL';
$getContent['template_path']  = ForAll::contIncPath() . 'template.php';
$getContent['header_path']    = ForAll::contIncPath() . 'header.php';
$getContent['body_path']      = ForAll::contIncPath() . 'body.php';
$getContent['fields_in_body'] = ['id', 'author_id', 'def_lang', 'created', 'edited', 'status'];
$getContent['lang_fields']    = ['heading'];
$getContent['order_by']       = 'DESC'; // or DESC
$getContent['extra']          = [];
$getContent['pagination']     = Config::getCfg('CFG_HISTORY_PAGINATION'); // or DESC

return $getContent;
