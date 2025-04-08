<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Fields\{ForAll, Review};

$created = GroupAccess::check([5]) ? ForAll::getI()->created(isset($v['created']) ? $v['created'] : '') : null;

if ($created !== null) {
    $created['required'] = true;
}

$rating = GroupAccess::check([2]) ? Review::getI()->rating(isset($v['rating']) ? $v['rating'] : '') : null;
$status = GroupAccess::check([5]) ? Review::getI()->status(isset($v['status']) ? $v['status'] : '') : null;

return [
    'rating'  => $rating,
    'created' => $created,
    'status'  => $status,
    'text'    => Review::getI()->text(isset($v['text']) ? $v['text'] : ''),
];
