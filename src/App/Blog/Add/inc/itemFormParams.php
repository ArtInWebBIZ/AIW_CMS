<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

$formParams = require PATH_INC . 'default' . DS . 'itemFormParams.php';

$formParams['enctype']       = true; // false or true
$formParams['section_css']   = 'content-section uk-margin-remove'; // sessions style
$formParams['container_css'] = 'uk-background-default'; // container style
$formParams['title']         = 'BLOG_ADD'; // or null
$formParams['fields']        = require PATH_APP . 'Blog' . DS . 'Add' . DS . 'inc' . DS . 'fields.php';
$formParams['url']           = 'blog/add/';
$formParams['cancel_url']    = 'hidden'; // or '/controller/action/' or 'hidden'
$formParams['button_label']  = 'BLOG_ADD';

return $formParams;
