<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Content;
use App\Blog\Add\Req\Func;

$getContent = Content::getDefaultValue();

$getContent['access'] = Func::getI()->checkAccess();
$getContent['tpl']    = 'admin';
$getContent['title']  = 'BLOG_ADD';

return $getContent;
