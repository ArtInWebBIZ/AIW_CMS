<?php

/**
 * @package    ArtInWebCMS.doc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Content;

return [
    'title'   => 'DOC_PRIVACY_POLICY',
    'index'   => 'index, follow',
    'content' => Content::getDocContent('privacy-policy'),
];
