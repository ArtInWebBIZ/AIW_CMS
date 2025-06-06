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
use Core\Plugins\Fields\ForAll;

$created = GroupAccess::check([5]) ? ForAll::getI()->created(isset($v['created']) ? $v['created'] : '') : null;

if ($created !== null) {
    $created['required'] = true;
}

return [
    'author_id' => GroupAccess::check([5]) ? Fields::getI()->authorId(isset($v['author_id']) ? $v['author_id'] : '') : null,
    'rating'    => Fields::getI()->rating(isset($v['rating']) ? $v['rating'] : ''),
    'created'   => $created,
    'text'      => Fields::getI()->text(isset($v['text']) ? $v['text'] : ''),
];
