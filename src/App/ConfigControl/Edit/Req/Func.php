<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\ConfigControl\Edit\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\{ParamsToSql, View\Tpl, Model\DB, Check\EditForm};
use Core\Plugins\Check\{GroupAccess, IntPageAlias};

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

    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                IntPageAlias::check() !== false &&
                $this->getConfigRow() !== false &&
                Auth::getUserStatus() == 1 &&
                (
                    Auth::getUserGroup() === (int) $this->getConfigRow()['group_access'] ||
                    GroupAccess::check([5])
                )
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private $getConfigRow = null;
    /**
     * @param array $params
     * @return mixed // array or false
     */
    public function getConfigRow(): array|false
    {
        if ($this->getConfigRow === null) {

            $this->getConfigRow = DB::getI()->getRow(
                [
                    'table_name' => 'config_control',
                    'where'      => '`id` = :id',
                    'array'      => ['id' => IntPageAlias::check()],
                ]
            );
        }

        return $this->getConfigRow;
    }

    public function viewEditForm()
    {
        $v = [
            'id'           => $this->getConfigRow()['id'],
            'params_name'  => $this->getConfigRow()['params_name'],
            'params_value' => $this->getConfigRow()['params_value'],
            'group_access' => $this->getConfigRow()['group_access'],
        ];

        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'      => false, // false or true
                'section_css' => 'content-section uk-padding-large',
                'title'        => 'CONFIG_PARAMETER_EDIT', // or null
                'url'          => 'config-control/edit/' . $this->getConfigRow()['id'] . '.html',
                'cancel_url'   => 'config-control/control/', // or '/controller/action/' or 'hidden'
                'v_image'  => null, // or image path
                'fields' => require PATH_APP . 'ConfigControl' . DS . 'Edit' . DS . 'inc' . DS . 'fields.php',
                'button_label' => 'OV_EDIT',
            ]
        );
    }

    private $checkForm = null;

    public function checkForm(): array
    {
        if ($this->checkForm === null) {

            $this->checkForm = EditForm::checkForm(PATH_APP . 'ConfigControl' . DS . 'Edit' . DS . 'inc' . DS . 'fields.php');
        }

        return $this->checkForm;
    }

    private $checkEditedFields = null;

    private function checkEditedFields(): array
    {
        if ($this->checkEditedFields === null) {

            $this->checkEditedFields = EditForm::checkEditedFields(
                $this->checkForm(),
                $this->getConfigRow()
            );
        }

        return $this->checkEditedFields;
    }

    private $countEditedFields = null;

    public function countEditedFields(): int
    {
        if ($this->countEditedFields === null) {

            $this->countEditedFields = count($this->checkEditedFields());
        }

        return $this->countEditedFields;
    }

    /**
     * @return boolean // true or false
     */
    public function updateEditedValues()
    {
        $checkEditedFields           = $this->checkEditedFields();
        $checkEditedFields['edited'] = time();

        return DB::getI()->update(
            [
                'table_name' => 'config_control',
                'set'        => ParamsToSql::getSet($checkEditedFields),
                'where'      => ParamsToSql::getSql(['id' => $this->getConfigRow()['id']]),
                'array'      => array_merge($checkEditedFields, ['id' => $this->getConfigRow()['id']]),
            ]
        );
    }

    public function saveEditToLog()
    {
        $set = [
            'edited_id'     => $this->getConfigRow()['id'],
            'editor_id'     => Auth::getUserId(),
            'edited_params' => $this->getConfigRow()['params_name'],
            'old_value'     => $this->getConfigRow()['params_value'],
            'new_value'     => $this->checkForm()['params_value'],
            'edited'        => time(),
        ];

        return DB::getI()->add(
            [
                'table_name' => 'config_control_edit_log',
                'set'        => ParamsToSql::getSet($set),
                'array'      => $set,
            ]
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
