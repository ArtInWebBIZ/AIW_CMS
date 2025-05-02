<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ContentType\Add\Req;

defined('AIW_CMS') or die;

use Core\Plugins\Check\CheckToken;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Style;
use Core\Plugins\View\Tpl;
use Core\Router;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $viewForm        = 'null';
    private $checkForm       = [];
    private $saveToDb        = 'null';

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
        }

        return $this->checkAccess;
    }
    /**
     * Return view add form
     * @return string
     */
    public function viewForm(): string
    {
        if ($this->viewForm == 'null') {

            $this->viewForm = Tpl::view(
                PATH_TPL . 'view' . DS . 'formView.php',
                [
                    'enctype'             => false, // false or true
                    'section_css'         => Style::form()['section_css'], // sessions style
                    'container_css'       => Style::form()['container_css'], // container style
                    'overflow_css'        => Style::form()['overflow_css'], // overflow style
                    'button_div_css'      => Style::form()['button_div_css'], // buttons div style
                    'submit_button_style' => '', // submit button style
                    'button_id'           => '',
                    'h'                   => 'h1', // title weight
                    'h_margin'            => 'uk-margin-large-bottom', // title style
                    'title'               => 'TITLE_CONSTANT', // or null
                    'url'                 => Router::getRoute()['controller_url'] . '/add/',
                    'cancel_url'          => Router::getRoute()['controller_url'], // or '/controller/action/' or 'hidden'
                    'v_image'             => null, // or image path
                    'fields'              => require ForAll::contIncPath() . 'fields.php',
                    'button_label'        => 'CONSTANT_BUTTON_LABEL',
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
            /**
             * Check form token
             */
            if (CheckToken::checkToken() === true) {

                $this->checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                    require ForAll::contIncPath() . 'fields.php'
                );
                #
            }
        }

        return $this->checkForm;
    }
    /**
     * Return new content type ID in data base
     * @return int
     */
    public function saveToDb(): int
    {
        if ($this->saveToDb == 'null') {

            $set = [];

            foreach ($this->checkForm() as $key => $value) {
                $set[$key] = $value;
            }
            unset($key, $value);

            $set['created'] = time();

            $this->saveToDb = (int) DB::getI()->add(
                [
                    'table_name' => str_replace("-", "_", Router::getRoute()['controller_url']),
                    'set'        => ParamsToSql::getSet($set),
                    'array'      => $set,
                ]
            );
        }

        return $this->saveToDb;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
