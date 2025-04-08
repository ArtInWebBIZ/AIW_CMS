<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Review\Edit\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Config};
use Core\Plugins\Check\{GroupAccess, IntPageAlias};
use Core\Plugins\Dll\ForAll;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\Style;
use Core\Plugins\View\Tpl;

class Func
{
    private static $instance = null;
    private $getReview       = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';
    /**
     * Check users access to edit this review
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (
                is_int(IntPageAlias::check()) &&
                $this->getReview() !== false &&
                Auth::getUserStatus() === 1 &&
                (
                    (
                        (int) $this->getReview()['author_id'] === Auth::getUserId() &&
                        (int) $this->getReview()['status'] === 0
                    ) ||
                    GroupAccess::check([5])
                )
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * @return mixed // array or false
     */
    public function getReview(): mixed
    {
        if ($this->getReview == 'null') {

            $this->getReview = DB::getI()->getRow(
                [
                    'table_name' => 'review',
                    'where'      => ParamsToSql::getSql(
                        $where = ['id' => IntPageAlias::check()]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->getReview;
    }

    public function viewForm()
    {
        $v = [
            'rating' => $this->getReview()['rating'],
            'created' => userDate(Config::getCfg('CFG_DATE_TIME_MYSQL_FORMAT'), $this->getReview()['created']),
            'status' => $this->getReview()['status'],
            'text'   => $this->getReview()['text'],
        ];

        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'             => false, // false or true
                'section_css'         => Style::form()['section_css'],
                'container_css'       => Style::form()['container_css'],
                'overflow_css'        => Style::form()['overflow_css'],
                'button_div_css'      => 'uk-margin-medium-top', // buttons div style
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'h_margin'            => 'uk-margin-bottom', // title style
                'title'               => 'REVIEW_EDIT', // or null
                'url'                 => 'review/edit/' . IntPageAlias::check() . '.html',
                'cancel_url'          => 'review/' . IntPageAlias::check() . '.html', // or '/controller/action/' or 'hidden'
                'v_image'             => null, // or image path
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'REVIEW_EDIT',
                'include_after_form'  => '', // include after form
            ]
        );
    }

    private $checkForm = [];

    public function checkForm(): array
    {
        if ($this->checkForm == []) {

            $this->checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require PATH_APP . 'Review' . DS . 'Edit' . DS . 'inc' . DS . 'fields.php'
            );
        }

        return $this->checkForm;
    }

    private $checkEditedFields = null;

    public function checkEditedFields(): array
    {
        if ($this->checkEditedFields === null) {

            $fieldsArr = require PATH_APP . 'Review' . DS . 'Edit' . DS . 'inc' . DS . 'fields.php';

            foreach ($fieldsArr as $key1 => $value1) {
                if ($fieldsArr[$key1] !== null) {
                    $activeFields[$key1] = '';
                }
            }

            $fieldsArr = array_keys($activeFields);

            $this->checkEditedFields = [];

            foreach ($fieldsArr as $key => $value) {

                if (
                    isset($this->checkForm()[$value]) &&
                    $this->checkForm()[$value] != $this->getReview()[$value]
                ) {
                    $this->checkEditedFields[$value] = $this->checkForm()[$value];
                }
            }
        }

        return $this->checkEditedFields;
    }

    public function saveEditedFields()
    {
        $checkEditedFields = $this->checkEditedFields();

        $return = [];

        foreach ($checkEditedFields as $key => $value) {

            $return = (bool) DB::getI()->update(
                [
                    'table_name' => 'review',
                    'set'        => ParamsToSql::getSet(
                        $set = [
                            $key => $value,
                            'edited' => time()
                        ]
                    ),
                    'where'      => ParamsToSql::getSql(
                        $where = ['id' => $this->getReview()['id']]
                    ),
                    'array'      => array_merge($set, $where),
                ]
            );

            if ($return === true) {
                /**
                 * Save edited params to log
                 * @return integer
                 */
                $return = (int) DB::getI()->add(
                    [
                        'table_name' => 'review_edit_log',
                        'set'        => ParamsToSql::getSet(
                            $set = [
                                'edited_id'    => $this->getReview()['id'],
                                'editor_id'    => Auth::getUserId(),
                                'edited_field' => $key,
                                'old_value'    => $key == 'text' ? '*** old text ***' : $this->getReview()[$key],
                                'new_value'    => $key == 'text' ? '*** new text ***' : $value,
                                'edited'       => time(),
                            ]
                        ),
                        'array'      => $set,
                    ]
                );
                #
            } else {
                $return['msg'] = 'MSG_SAVE_TO_DATABASE_ERROR';
                break;
            }

            if ($return > 0) {
                $return = true;
            } else {
                $return['msg'] = 'MSG_SAVE_TO_DATABASE_ERROR';
                break;
            }
        }

        return $return;
    }

    private function __clone() {}
    public function __wakeup() {}
}
