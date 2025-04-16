<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

return             [
    'enctype'             => false, // false or true
    'section_css'         => 'content-section uk-margin-remove', // sessions style
    'container_css'       => '', // container style
    // 'overflow_css'        => '', // overflow style
    'button_div_css'      => 'uk-margin-medium-top', // buttons div style
    'submit_button_style' => '', // submit button style
    'button_id'           => '',
    'h'                   => 'h1', // title weight
    'h_margin'            => 'uk-margin-large-bottom', // title style
    'title'               => 'title', // or null
    'url'                 => 'page_link',
    'cancel_url'          => null, // or '/controller/action/' or 'hidden'
    'v_image'             => null, // or image path
    // 'fields'              => require PATH_APP . 'ContentType' . DS . 'Add' . DS . 'inc' . DS . 'fields.php',
    'button_label'        => 'title',
    'include_after_form'  => '', // include after form
];
