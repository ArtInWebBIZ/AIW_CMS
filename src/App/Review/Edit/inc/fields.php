<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\Review\Lib\Fields;
use Core\Plugins\Check\GroupAccess;
use App\Review\Edit\Req\Func;
use Core\Auth;

$rating = (int) Func::getI()->getReview()['author_id'] === Auth::getUserId() ?
    Fields::getI()->rating(isset($v['rating']) ? $v['rating'] : '') : null;

$status = GroupAccess::check([5]) ?
    Fields::getI()->status(isset($v['status']) ? $v['status'] : '') : null;

return [
    'rating'  => $rating,
    'status'  => $status,
    'text'    => Fields::getI()->text(isset($v['text']) ? $v['text'] : ''),
];
