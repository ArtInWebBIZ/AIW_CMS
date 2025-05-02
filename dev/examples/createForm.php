<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace PasteNameSpace; // VALUE IS EXAMPLE

defined('AIW_CMS') or die;

use Core\GV;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;
use Core\Plugins\View\Tpl;
use Core\Router;

class ClassName // VALUE IS EXAMPLE
{
    /**
     * Get form to page
     * @return string
     */
    private function viewForm(): string
    {
        /**
         * If global variable not empty, get to form actual values
         */
        if (is_array(GV::post())) {

            $v = [];

            foreach ($this->checkForm() as $key => $value) {
                $v[$key] = $value;
            }
            unset($key, $value);
        }

        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'             => false, // false or true
                'section_css'         => Style::form()['section_css'], // sessions style
                'container_css'       => Style::form()['container_css'], // container style
                'overflow_css'        => Style::form()['overflow_css'], // overflow style
                'button_div_css'      => Style::form()['button_div_css'], // buttons div style
                'h_margin'            => Style::form()['h_margin'], // title style
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'title'               => 'TITLE_CONSTANT', // or null
                'url'                 => Router::getRoute()['controller_name'] . '/action/',
                'cancel_url'          => null, // or '/controller/action/' or 'hidden'
                'v_image'             => null, // or image path
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'CONSTANT_BUTTON_LABEL',
                'include_after_form'  => '', // include after form
            ]
        );
    }
}
