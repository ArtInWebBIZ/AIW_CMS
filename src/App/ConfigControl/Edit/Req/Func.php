<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ConfigControl\Edit\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\{ParamsToSql, View\Tpl, Model\DB};
use Core\Plugins\Check\{CheckForm, GroupAccess, IntPageAlias};
use Core\Plugins\Lib\ForAll;

class Func
{
    private static $instance   = null;
    private $checkAccess       = 'null';
    private $checkEditedFields = null;
    private $checkForm         = null;
    private $getConfigRow      = null;

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
    /**
     * Get all values current config`s parameter
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
    /**
     * View edit form
     * @return string
     */
    public function viewEditForm(): string
    {
        $v = [];

        foreach ($this->getConfigRow() as $key => $value) {
            $v[$key] = $value;
        }
        unset($key, $value);

        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'      => false, // false or true
                'section_css' => 'content-section uk-padding-large',
                'title'        => 'CONFIG_PARAMETER_EDIT', // or null
                'url'          => 'config-control/edit/' . $this->getConfigRow()['id'] . '.html',
                'cancel_url'   => 'config-control/control/', // or '/controller/action/' or 'hidden'
                'v_image'  => null, // or image path
                'fields' => require ForAll::contIncPath() . 'fields.php',
                'button_label' => 'OV_EDIT',
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

    public function checkEditedFields(): array
    {
        if ($this->checkEditedFields === null) {

            $this->checkEditedFields = CheckForm::checkEditedFields(
                $this->checkForm(),
                $this->getConfigRow()
            );
        }

        return $this->checkEditedFields;
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
    /**
     * Save new values to log
     * @return bool
     */
    public function saveEditToLog(): bool
    {
        $saveToEditLog = false;

        $insertToLog = [];

        foreach ($this->checkEditedFields() as $key => $value) {
            $insertToLog[] = [
                'edited_id'    => $this->getConfigRow()['id'],
                'editor_id'    => Auth::getUserId(),
                'edited_params' => $key,
                'old_value'    => $this->getConfigRow()[$key],
                'new_value'    => $value,
                'edited'       => time(),
            ];
        }

        $saveToEditLog = DB::getI()->insertInto(
            'config_control_edit_log',
            $insertToLog
        );

        return $saveToEditLog;
    }

    private function __clone() {}
    public function __wakeup() {}
}
