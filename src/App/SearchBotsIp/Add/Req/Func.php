<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\SearchBotsIp\Add\Req;

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Tpl;
use Core\Router;

class Func
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';

    public function checkAccess()
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (GroupAccess::check([5])) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    #
    private $viewForm = 'null';
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
                    'section_css'         => 'uk-margin-small', // sessions style
                    'container_css'       => '', // container style
                    'overflow_css'        => '', // overflow style
                    'button_div_css'      => 'uk-margin-medium-top', // buttons div style
                    'submit_button_style' => '', // submit button style
                    'button_id'           => '',
                    'h'                   => 'h1', // title weight
                    'h_margin'            => 'uk-margin-large', // title style
                    'title'               => 'SBIP_ADD', // or null
                    'url'                 => Router::getRoute()['controller_url'] . '/add/',
                    'cancel_url'          => Router::getRoute()['controller_url'],
                    'v_image'             => null, // or image path
                    'fields'              => require PATH_APP . Router::getRoute()['controller_name'] . DS . 'Add' . DS . 'inc' . DS . 'fields.php',
                    'button_label'        => 'SBIP_ADD',
                    'include_after_form'  => '', // include after form
                ]
            );
        }

        return $this->viewForm;
    }
    #
    private $checkForm = [];
    /**
     * Checked values $_POST
     * @param array $fieldArr
     * @return array // if error enabled key ['msg']
     */
    public function checkForm(): array
    {
        if ($this->checkForm == []) {

            $this->checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require PATH_APP . Router::getRoute()['controller_name'] . DS . 'Add' . DS . 'inc' . DS . 'fields.php'
            );
        }

        return $this->checkForm;
    }
    #
    private $saveToDb = 'null';
    /**
     * Return new content type ID in data base
     * @return int
     */
    public function saveToDb(): int
    {
        if ($this->saveToDb == 'null') {

            $set = [];

            foreach ($this->checkForm() as $key => $value) {
                if (
                    $key == 'start_range' ||
                    $key == 'end_range'
                ) {
                    $set[$key] = ip2long($value);
                } else {
                    $set[$key] = $value;
                }
            }

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
