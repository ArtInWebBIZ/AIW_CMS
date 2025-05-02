<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ConfigControl\Add\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Router};
use Core\Plugins\{ParamsToSql, View\Tpl, Model\DB};
use Core\Plugins\Check\CheckForm;
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;

class Func
{
    private static $instance = null;
    private $checkForm       = null;
    private $saveNewParameter = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';

    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {
            $this->checkAccess = Auth::getUserGroup() === 5 && Auth::getUserStatus() === 1 ? true : false;
        }

        return $this->checkAccess;
    }

    public function viewForm()
    {
        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'        => false, // false or true
                'section_css'    => Style::form()['section_css'],
                'container_css'  => Style::form()['container_css'],
                'overflow_css'   => Style::form()['overflow_css'],
                'h_margin'       => Style::form()['h_margin'],
                'button_div_css' => Style::form()['button_div_css'],
                'title'          => 'CONFIG_PARAMETER_ADD',
                'url'            => Router::getRoute()['controller_url'] . '/add/',
                'cancel_url'     => Router::getRoute()['controller_url'] . '/control/',
                'v_image'        => null,
                'fields'         => require ForAll::contIncPath() . 'fields.php',
                'button_label'   => 'CONFIG_PARAMETER_ADD',
            ]
        );
    }

    public function checkForm(): array
    {
        if ($this->checkForm === null) {
            $this->checkForm = CheckForm::check(ForAll::contIncPath() . 'fields.php');
        }

        return $this->checkForm;
    }

    public function saveNewParameter(): int
    {
        if ($this->saveNewParameter == 'null') {

            $params = [
                'params_name'  => $this->checkForm()['params_name'],
                'params_value' => $this->checkForm()['params_value'],
                'value_type'   => $this->checkForm()['value_type'],
                'group_access' => $this->checkForm()['group_access'],
            ];

            $this->saveNewParameter = DB::getI()->add(
                [
                    'table_name' => 'config_control',
                    'set'        => ParamsToSql::getSet($params),
                    'array'      => $params,
                ]
            );
        }

        return $this->saveNewParameter;
    }

    private function __clone() {}
    public function __wakeup() {}
}
