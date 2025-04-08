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

return [
    'author_id' => GroupAccess::check([5]) ? Review::getI()->authorId(isset($v['author_id']) ? $v['author_id'] : '') : null,
    'rating'    => Review::getI()->rating(isset($v['rating']) ? $v['rating'] : ''),
    'created'   => $created,
    'text'      => Review::getI()->text(isset($v['text']) ? $v['text'] : ''),
];
