<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */


use Core\Content;
use App\Blog\Add\Req\Func;

defined('AIW_CMS') or die;

$getContent = Content::getDefaultValue();

$getContent['access'] = Func::getI()->checkAccess();
$getContent['tpl']    = 'admin';
$getContent['title']  = 'BLOG_EDIT';

return $getContent;
