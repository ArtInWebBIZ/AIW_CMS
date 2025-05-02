<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;

defined('AIW_CMS') or die;

$formParams = PATH_INC . 'default' . DS . 'itemFormParams.php';

// $formParams['enctype']             = false; // false or true
// $formParams['session_css']         = Style::form()['session_css']; // sessions style
// $formParams['container_css']       = Style::form()['container_css']; // container style
// $formParams['overflow_css']        = Style::form()['overflow_css']; // overflow style
// $formParams['button_div_css']      = Style::form()['button_div_css']; // buttons div style
// $formParams['submit_button_style'] = Style::form()['submit_button_style']; // submit button style
// $formParams['h_margin']            = Style::form()['h_margin']; // title style
// $formParams['button_id']           = '';
// $formParams['h']                   = 'h1'; // title weight
// $formParams['title']               = 'TITLE_CONSTANT'; // or null
// $formParams['url']                 = 'page_link';
// $formParams['cancel_url']          = null; // or '/controller/action/' or 'hidden'
// $formParams['v_image']             = null; // or image path
// $formParams['fields']              = require ForAll::contIncPath() . 'fields.php';
// $formParams['button_label']        = 'CONSTANT_BUTTON_LABEL';
// $formParams['include_after_form']  = ''; // include after form

return $formParams;
