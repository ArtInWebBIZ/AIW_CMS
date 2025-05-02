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
     * Get form TO CONTENT in page
     * @return string
     */
    public function onlyForm(): string
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
            PATH_TPL . 'view' . DS . 'onlyForm.php',
            [
                'enctype'             => false, // false or true
                'container_css'       => '', // container style !!! NOT CHANGE_THIS !!!
                'button_div_css'      => Style::form()['button_div_css'], // buttons div style
                'h_margin'            => Style::form()['h_margin'], // title style
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'title'               => 'TITLE_CONSTANT', // or null // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
                'url'                 => Router::getRoute()['controller_url'] . '/action/', // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
                'cancel_url'          => null, // or Router::getRoute()['controller_url'] . '/action/' or 'hidden'
                'v_image'             => null, // or image path
                'fields'              => require ForAll::contIncPath() . 'fields.php', // VALUE IS EXAMPLE
                'button_label'        => 'CONSTANT_BUTTON_LABEL', // VALUE IS EXAMPLE  !!! CHANGE_THIS !!!
                'include_after_form'  => '', // include after form
            ]
        );
    }
}
