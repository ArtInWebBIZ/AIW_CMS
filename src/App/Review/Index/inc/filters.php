<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\Review\Lib\Fields;

$authorId = Fields::getI()->authorId(isset($v['author_id']) ?: '');
$authorId['required'] = false;

return [
    // 'author_id' => $authorId
];
