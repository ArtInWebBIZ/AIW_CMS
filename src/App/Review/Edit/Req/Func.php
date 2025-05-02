<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Review\Edit\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Config};
use Core\Plugins\Check\{CheckForm, GroupAccess, IntPageAlias};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\View\{Style, Tpl};

class Func
{
    private static $instance = null;
    private $checkAccess       = 'null';
    private $getReview         = 'null';
    private $checkForm         = [];
    private $checkEditedFields = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
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
    private function getReview(): mixed
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
    /**
     * View edited form
     * @return string
     */
    public function viewForm(): string
    {
        $v = [];

        foreach ($this->getReview() as $key => $value) {
            $v[$key] = $value;
        }
        unset($key, $value);

        $v['created'] = userDate(Config::getCfg('CFG_DATE_TIME_MYSQL_FORMAT'), $this->getReview()['created']);

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
    /**
     * Check corrects value from form
     * @return array
     */
    public function checkForm(): array
    {
        if ($this->checkForm == []) {
            $this->checkForm = CheckForm::check(ForAll::contIncPath() . 'fields.php');
        }

        return $this->checkForm;
    }
    /**
     * Check edited fields
     * @return array
     */
    public function checkEditedFields(): array
    {
        if ($this->checkEditedFields === null) {

            $this->checkEditedFields = CheckForm::checkEditedFields(
                $this->checkForm(),
                $this->getReview()
            );
            #
        }

        return $this->checkEditedFields;
    }
    /**
     * Update review
     * @return boolean|array
     */
    public function updateReview(): bool|array
    {
        $return = false;

        $return = DB::getI()->update(
            [
                'table_name' => 'review',
                'set'        => ParamsToSql::getSet(
                    $set = $this->checkEditedFields()
                ),
                'where'      => ParamsToSql::getSql(
                    $where = [
                        'id' => $this->getReview()['id'],
                    ]
                ),
                'array'      => array_merge($set, $where),
            ]
        );

        if ($return === true) {
            $return = $this->saveToLog();
        }

        if ($return === false) {
            $return['msg'] = 'MSG_SAVE_TO_DATABASE_ERROR';
        }

        return $return;
    }
    /**
     * Save to log change history
     * @return boolean
     */
    private function saveToLog(): bool
    {
        $insertToLog = [];

        foreach ($this->checkEditedFields() as $key => $value) {
            $insertToLog[] = [
                'edited_id'    => $this->getReview()['id'],
                'editor_id'    => Auth::getUserId(),
                'edited_field' => $key,
                'old_value'    => $key == 'text' ? '*** old text ***' : $this->getReview()[$key],
                'new_value'    => $key == 'text' ? '*** new text ***' : $value,
                'edited'       => time(),
            ];
        }
        unset($key, $value);

        return DB::getI()->insertInto(
            'review_edit_log',
            $insertToLog
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
