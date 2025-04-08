<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Review\Add\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Config, Session, Trl};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\View\{Tpl, Style};
use Core\Plugins\Dll\Review;
use Core\Plugins\Model\DB;
use Core\Plugins\Select\Review\Status;
use Core\Plugins\{ParamsToSql, Ssl};
use Core\Plugins\Dll\ForAll;

class Func
{
    private static $instance   = null;
    private $latestUsersReview = null;
    private $checkAccess       = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() === 1 &&
                (
                    (
                        $this->latestUsersReview() === [] ||
                        (
                            time() > (int) $this->latestUsersReview()['created'] + Config::getCfg('CFG_MAX_SESSION_TIME') &&
                            (int) $this->latestUsersReview()['status'] === Status::getI()->clear()['REVIEW_PUBLISHED']
                        )
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
     * Get in array latest users review or empty array
     * @return array // array or []
     */
    public function latestUsersReview(): array
    {
        if ($this->latestUsersReview === null) {
            $this->latestUsersReview = Review::getI()->latestUsersReview(Auth::getUserId());
        }

        return $this->latestUsersReview;
    }

    public function viewForm()
    {
        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'             => false, // false or true
                'section_css'         => Style::form()['section_css'],
                'container_css'       => Style::form()['container_css'],
                'overflow_css'        => Style::form()['overflow_css'],
                'h_margin'            => Style::form()['h_margin'],
                'button_div_css'      => Style::form()['button_div_css'],
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'title'               => 'REVIEW_ADD', // or null
                'url'                 => 'review/add/',
                'cancel_url'          => 'hidden', // or '/controller/action/' or 'hidden'
                'v_image'             => null, // or image path
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'REVIEW_ADD',
                'include_after_form'  => '', // include after form
            ]
        );
    }

    private $checkForm = [];

    public function checkForm(): array
    {
        if ($this->checkForm == []) {

            $this->checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require ForAll::contIncPath() . 'fields.php'
            );
        }

        return $this->checkForm;
    }

    private $saveReview = 'null';

    public function saveReview(): int
    {
        if ($this->saveReview === 'null') {

            if (GroupAccess::check([5])) {

                $this->saveReview = DB::getI()->add(
                    [
                        'table_name' => 'review',
                        'set'        => ParamsToSql::getSet(
                            $set = [
                                'author_id' => $this->checkForm()['author_id'],
                                'lang'      => Session::getLang(),
                                'text'      => $this->checkForm()['text'],
                                'rating'    => $this->checkForm()['rating'],
                                'created'   => $this->checkForm()['created'],
                                'edited'    => $this->checkForm()['created'],
                            ]
                        ),
                        'array'      => $set,
                    ]
                );
                #
            } else {

                $this->saveReview = Review::getI()->add(
                    [
                        'text'   => $this->checkForm()['text'],
                        'rating' => $this->checkForm()['rating'],
                    ]
                );
            }
        }

        return $this->saveReview;
    }

    public function sendEmail()
    {
        return (new \Core\Modules\Email)->sendEmail(
            Config::getCfg('CFG_REPLY_TO'),
            Trl::_('EMAIL_NEW_REVIEW_SUBJECT'),
            Trl::sprintf('EMAIL_NEW_REVIEW_TEXT', ...[
                Ssl::getLinkLang() . 'review/edit/' . $this->saveReview() . '.html',
                Ssl::getLinkLang() . 'review/edit/' . $this->saveReview() . '.html',
            ])
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
