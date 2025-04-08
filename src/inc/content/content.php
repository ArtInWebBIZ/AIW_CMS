<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;
use Core\Plugins\Ssl;

return [
    'tpl'            => 'index',
    'refresh'        => '',
    'meta'           => '',
    'robots'         => 'noindex, nofollow',
    'canonical'      => '',
    'alternate'      => '',
    'sitemap_order'  => 0,
    'description'    => '',
    'keywords'       => '',
    'author'         => Trl::_('OV_SITE_NAME'),
    'title'          => 'OV_PAGE_TITLE',
    'image'          => Ssl::getLink() . '/img/logo_h80.png',
    'og'             => '',
    'redirect'       => '',
    'toTopStyles'    => '',
    'toTopScript'    => '',
    'msg'            => '',
    'content'        => '',
    'toBottomScript' => '',
];
