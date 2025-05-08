<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Admin\FindUniqueSymbols\Req;

use Core\{GV, Router};
use Core\Plugins\Check\{CheckForm, GroupAccess};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\{Style, Tpl};

defined('AIW_CMS') or die;

class Func
{
    private static $instance    = null;
    private $checkAccess        = 'null';
    private $view               = 'null';
    private $checkForm          = [];
    private $checkUniqueSymbols = 'null';

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
    public function view(): string
    {
        if ($this->view == 'null') {

            $this->view = Tpl::view(
                ForAll::contIncPath() . 'template.php',
                [
                    'header' => $this->viewForm(),
                    'body'   => $this->checkUniqueSymbols(),
                ]
            );
        }

        return $this->view;
    }
    #
    private function viewForm()
    {
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
                'enctype'             => false,
                'container_css'       => Style::form()['container_css'],
                'button_div_css'      => Style::form()['button_div_css'],
                'h_margin'            => Style::form()['h_margin'],
                'submit_button_style' => '',
                'button_id'           => '',
                'h'                   => 'h1',
                'title'               => 'ADMIN_FIND_UNIQUE_SYMBOLS',
                'url'                 => Router::getRoute()['controller_url'] . '/find-unique-symbols/',
                'cancel_url'          => 'hidden',
                'v_image'             => null,
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'ADMIN_FIND_UNIQUE_SYMBOLS',
                'include_after_form'  => '',
            ]
        );
    }
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    private function checkForm(): array
    {
        if ($this->checkForm == []) {
            $this->checkForm = CheckForm::check(ForAll::contIncPath() . 'fields.php');
        }

        return $this->checkForm;
    }
    /**
     * Return in string unique symbols
     * @return string
     */
    private function checkUniqueSymbols(): string
    {
        if ($this->checkUniqueSymbols === 'null') {

            $html = '';

            if (
                is_array(GV::post()) &&
                !isset($this->checkForm()['msg'])
            ) {

                $languageAlphabet = require PATH_INC . 'crypt' . DS . 'alphabet' . DS . $this->checkForm()['lang_file'];
                /**
                 * Get all symbols array
                 */
                $allSymbols = require PATH_INC . 'crypt' . DS . 'alphabetList.php';


                foreach ($languageAlphabet as $key => $symbol) {
                    if (array_search($symbol, $allSymbols, true) === false) {
                        $html .= '\'' . $symbol . '\', ';
                    }
                }
                unset($key, $symbol);

                if ($html === '') {
                    $html = 'No uniques symbol';
                } else {
                    $html = trim($html, ", ");
                }
            }

            $this->checkUniqueSymbols = $html;
        }

        return $this->checkUniqueSymbols;
    }

    private function __clone() {}
    public function __wakeup() {}
}
