<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Admin\CleanHtml\Req;

defined('AIW_CMS') or die;

use Core\{GV, Router};
use Core\Plugins\Check\{CheckForm, GroupAccess};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\{Style, Tpl};

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $checkForm = [];

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

    public function view()
    {
        return Tpl::view(
            ForAll::contIncPath() . 'template.php',
            [
                'form' => $this->viewForm(),
                'body' => is_array(GV::post()) && !isset($this->checkForm()['msg']) ?
                    $this->checkForm()['clean_html'] : '',
            ]
        );
    }
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
            PATH_TPL . 'view' . DS . 'onlyForm.php',
            [
                'enctype'             => false,
                'container_css'       => '',
                'button_div_css'      => Style::form()['button_div_css'],
                'h_margin'            => Style::form()['h_margin'],
                'submit_button_style' => '',
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'title'               => null,
                'url'                 => Router::getRoute()['controller_url'] . '/clean-html/',
                'cancel_url'          => 'hidden', // or Router::getRoute()['controller_url'] . '/action/' or 'hidden'
                'v_image'             => null,
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'ADMIN_CLEAN_HTML',
                'include_after_form'  => '',
            ]
        );
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

    private function __clone() {}
    public function __wakeup() {}
}
