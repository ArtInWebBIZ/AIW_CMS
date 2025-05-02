<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */
defined('AIW_CMS') or die;

use Core\Plugins\Check\{IntPageAlias, Item};
use Core\Plugins\Lib\ForAll;
use Core\Router;

$formParams = require PATH_INC . 'default' . DS . 'itemFormParams.php';

$formParams['enctype']       = true; // false or true
$formParams['section_css']   = 'content-section uk-margin-remove'; // sessions style
$formParams['container_css'] = 'uk-background-default'; // container style
$formParams['title']         = 'BLOG_EDIT'; // or null
$formParams['fields']        = require ForAll::contIncPath() . 'fields.php';
$formParams['url']           = Router::getRoute()['controller_url'] . '/edit/' . Item::getI()->checkItem()['id'] . '.html';
$formParams['v_image']       = Item::getI()->getImgPath(); // or image path
$formParams['cancel_url']    = Router::getRoute()['controller_url'] . '/' . IntPageAlias::check() . '.html';
$formParams['button_label']  = 'BLOG_EDIT';

return $formParams;
