<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\ItemController\Add\Req;

use Core\Auth;
use Core\Plugins\Check\CheckForm;
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Tpl;

defined('AIW_CMS') or die;

class Func
{
    private static $instance = null;
    private $checkAccess = 'null';
    private $checkForm = [];
    private $checkCorrectControllerUrl = 'null';
    private $saveControllerUrl = 'null';

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
        if ($this->checkAccess === 'null') {
            $this->checkAccess = false;

            if (
                Auth::getUserStatus() === 1 &&
                GroupAccess::check([5])
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Check controller`s url
     * @return void
     */
    public function checkCorrectControllerUrl(): array | false
    {
        if ($this->checkCorrectControllerUrl === 'null') {

            $this->checkCorrectControllerUrl = DB::getI()->getRow(
                [
                    'table_name' => 'table_name',
                    'where'      => ParamsToSql::getSql(
                        $where = ['controller_url' => $this->checkForm()['controller_url']]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkCorrectControllerUrl;
    }
    /**
     * View add form
     * @return string
     */
    public function viewForm(): string
    {
        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'             => false, // false or true
                'section_css'         => 'uk-margin-remove uk-padding-remove', // sessions style
                'container_css'       => 'uk-background-default uk-padding-large', // container style
                'overflow_css'        => ' overflow-hidden uk-flex uk-flex-column uk-flex-center', // overflow style
                'button_div_css'      => 'uk-margin-medium-top', // buttons div style
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'h_margin'            => 'uk-margin-large', // title style
                'title'               => 'ITEM_CONTROLLER_URL_ADD', // or null
                'url'                 => 'item-controller/add/',
                'cancel_url'          => 'item-controller', // or '/controller/action/' or 'hidden'
                'v_image'             => null, // or image path
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'ITEM_CONTROLLER_URL_ADD',
                'include_after_form'  => '', // include after form
            ]
        );
    }

    public function checkForm(): array
    {
        if ($this->checkForm == []) {
            $this->checkForm = CheckForm::check(ForAll::contIncPath() . 'fields.php');
        }

        return $this->checkForm;
    }

    public function saveControllerUrl(): int
    {
        if ($this->saveControllerUrl === 'null') {

            $this->saveControllerUrl = (int) DB::getI()->add(
                [
                    'table_name' => 'item_controller',
                    'set'        => ParamsToSql::getSet(
                        $set = [
                            'controller_url' => $this->checkForm()['controller_url'],
                            'filters_table'  => $this->checkForm()['filters_table'],
                            'created'        => time()
                        ]
                    ),
                    'array'      => $set,
                ]
            );
        }

        return $this->saveControllerUrl;
    }

    private function __clone() {}
    public function __wakeup() {}
}
