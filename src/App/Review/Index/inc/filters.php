<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Fields\Review;

$authorId = Review::getI()->authorId(isset($v['author_id']) ?: '');
$authorId['required'] = false;

return [
    // 'author_id' => $authorId
];
