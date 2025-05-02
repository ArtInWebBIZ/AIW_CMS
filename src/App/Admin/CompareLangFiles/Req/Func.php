<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Admin\CompareLangFiles\Req;

use Core\GV;
use Core\Plugins\Check\{CheckForm, GroupAccess};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\Select\Other\Languages;
use Core\Plugins\View\{Style, Tpl};

defined('AIW_CMS') or die;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $viewForm        = 'null';
    private $checkForm       = [];
    private $view            = 'null';
    private $body            = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check user`s access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (GroupAccess::check([5])) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Return …
     * @return string
     */
    private function viewForm(): string
    {
        if ($this->viewForm == 'null') {

            if (is_array(GV::post())) {

                $v = [];

                foreach ($this->checkForm() as $key => $value) {
                    $v[$key] = $value;
                }
                unset($key, $value);
            }

            $this->viewForm = Tpl::view(
                PATH_TPL . 'view' . DS . 'onlyForm.php',
                [
                    'enctype'             => false, // false or true
                    'container_css'       => Style::form()['container_css'], // container style
                    'button_div_css'      => Style::form()['button_div_css'], // buttons div style
                    'h_margin'            => Style::form()['h_margin'], // title style
                    'submit_button_style' => '', // submit button style
                    'button_id'           => '',
                    'h'                   => 'h1', // title weight
                    'title'               => null, // or null
                    'url'                 => 'admin/compare-lang-files/',
                    'cancel_url'          => 'hidden', // or '/controller/action/' or 'hidden'
                    'v_image'             => null, // or image path
                    'fields'              => require ForAll::contIncPath() . 'fields.php',
                    'button_label'        => 'ADMIN_COMPARE_LANG_FILES',
                    'include_after_form'  => '', // include after form
                ]
            );
        }

        return $this->viewForm;
    }
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    public function checkForm(): array
    {
        if ($this->checkForm == []) {
            $this->checkForm = CheckForm::check(ForAll::contIncPath() . 'fields.php');
        }

        return $this->checkForm;
    }
    /**
     * Return …
     * @return string
     */
    public function view(): string
    {
        if ($this->view == 'null') {

            if (is_array(GV::post())) {

                $langs = array_flip(Languages::getI()->clear());

                $header = !isset($this->checkForm()['msg']) ? Tpl::view(
                    ForAll::contIncPath() . 'header.php',
                    [
                        'first_lang_label' => $langs[$this->checkForm()['first_lang']],
                        'second_lang_label' => $langs[$this->checkForm()['second_lang']]
                    ]
                ) : '';

                $body = !isset($this->checkForm()['msg']) ? $this->body() : '';

                $fileName = isset($this->checkForm()['file_name']) ? $this->checkForm()['file_name'] : '';
                #
            } else {
                $header   = '';
                $body     = '';
                $fileName = '';
            }

            $this->view = Tpl::view(
                ForAll::contIncPath() . 'template.php',
                [
                    'form'      => $this->viewForm(),
                    'file_name' => $fileName,
                    'header'    => $header,
                    'body'      => $body,

                ]
            );
        }

        return $this->view;
    }
    /**
     * Return …
     * @return string
     */
    private function body(): string
    {
        if ($this->body == 'null') {

            $html = '';

            if (file_exists(PATH_LANG . $this->checkForm()['first_lang'] . DS . $this->checkForm()['file_name'])) {
                $firstLang = require PATH_LANG . $this->checkForm()['first_lang'] . DS . $this->checkForm()['file_name'];
            } else {
                $html = '<h2 class="uk-text-center uk-margin-medium-bottom">Not exist file "' . $this->checkForm()['file_name'] . '" in language directory "' . $this->checkForm()['first_lang'] . '" </h2>';
            }

            if (file_exists(PATH_LANG . $this->checkForm()['second_lang'] . DS . $this->checkForm()['file_name'])) {
                $secondLang = require PATH_LANG . $this->checkForm()['second_lang'] . DS . $this->checkForm()['file_name'];
            } else {
                $html = '<h2 class="uk-text-center uk-margin-medium-bottom">Not exist file "' . $this->checkForm()['file_name'] . '" in language directory "' . $this->checkForm()['second_lang'] . '" </h2>';
            }

            if ($html === '') {

                foreach ($firstLang as $key => $value) {

                    $html .= Tpl::view(
                        ForAll::contIncPath() . 'body.php',
                        [
                            'first_lang'  => $firstLang[$key],
                            'key'         => $key,
                            'second_lang' => isset($secondLang[$key]) ? $secondLang[$key] : '',
                        ]
                    );

                    if (isset($secondLang[$key])) {
                        unset($secondLang[$key]);
                    }
                }
                unset($key, $value);

                if ($secondLang !== []) {

                    foreach ($secondLang as $key => $value) {

                        $html .= Tpl::view(
                            ForAll::contIncPath() . 'body.php',
                            [
                                'first_lang'  => '',
                                'key'         => $key,
                                'second_lang' => $secondLang[$key],
                            ]
                        );
                    }
                    unset($key, $value);
                }
            }

            $this->body = $html;
        }

        return $this->body;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
