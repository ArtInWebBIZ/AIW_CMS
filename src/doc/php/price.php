<?php

/**
 * @package    ArtInWebCMS.doc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\View\Tpl;

return [
    'title'   => 'PHOTO_PRICE',
    'index'   => 'index, follow',
    'content' => Tpl::view(PATH_INC . 'doc' . DS . 'price.php'),
];
