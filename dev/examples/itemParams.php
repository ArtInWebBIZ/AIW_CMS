<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */


use Core\Content;
use App\Blog\Control\Req\Func;
use Core\Config;
use Core\Plugins\Lib\ForAll;

defined('AIW_CMS') or die;

$defContentValues = Content::getDefaultValue();

$defContentValues['access']         = Func::getI()->checkAccess();
$defContentValues['tpl']            = 'admin';
// $defContentValues['refresh']        = Auth::getUserGroup() < 3 ? '' : '<meta http-equiv="refresh" content="' . Config::getCfg('CFG_TIME_REFRESH') . '">';
// $defContentValues['meta']           = '';
// $defContentValues['description']    = '';
// $defContentValues['keywords']       = '';
// $defContentValues['author']         = Trl::_('OV_SITE_NAME');
$defContentValues['title']          = 'TITLE_CONSTANT';
// $defContentValues['image']          = Ssl::getLink() . '/img/logo.jpg';
// $defContentValues['og']             = '';
// $defContentValues['redirect']       = '';
// $defContentValues['sitemap_order']  = 0;
// $defContentValues['robots']         = 'noindex, nofollow, noarchive';
// $defContentValues['toTopStyles']    = '';
// $defContentValues['toTopScript']    = '';
// $defContentValues['msg']            = '';
// $defContentValues['toBottomScript'] = '';
$defContentValues['template_path']  = ForAll::contIncPath() . 'template.php';
$defContentValues['header_path']    = ForAll::contIncPath() . 'header.php';
$defContentValues['body_path']      = ForAll::contIncPath() . 'body.php';
$defContentValues['fields_in_body'] = ['id', 'author_id', 'def_lang', 'created', 'edited', 'status'];
$defContentValues['lang_fields']    = ['heading'];
$defContentValues['order_by']       = 'DESC'; // or DESC
// $defContentValues['extra']          = [
//     'status' => 0
//     // 'author_id' => Auth::getUserId()
// ];
$defContentValues['pagination']     = Config::getCfg('CFG_HISTORY_PAGINATION'); // or DESC

return $defContentValues;
