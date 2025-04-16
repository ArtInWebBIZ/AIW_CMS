<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Review\View\Req;

use Core\{Auth};
use Core\Plugins\{Model\DB, ParamsToSql};
use Core\Plugins\Check\{GroupAccess, IntPageAlias};
use Core\Plugins\Dll\ForAll;
use Core\Plugins\View\Tpl;

defined('AIW_CMS') or die;

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

    private $checkAccess = null;
    /**
     * Get user access to review view
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess === null) {

            $this->checkAccess = false;

            if (
                IntPageAlias::check() !== false &&
                $this->getReview() !== false &&
                (
                    (int) $this->getReview()['status'] === ForAll::contentStatus()['REVIEW_PUBLISHED'] ||
                    (
                        Auth::getUserStatus() === 1 &&
                        (
                            (int) $this->getReview()['author_id'] === Auth::getUserId() ||
                            GroupAccess::check([5]) === true
                        )
                    )
                )
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Get review row in array or false
     * @return mixed // array or false
     */
    public function getReview(): array|false
    {
        if ($this->getReview === 'null') {

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

    public function viewReview(): string
    {
        return Tpl::view(
            ForAll::contIncPath() . 'view.php',
            [
                'id'          => $this->getReview()['id'],
                'author_id'   => $this->getReview()['author_id'],
                'text'        => $this->getReview()['text'],
                'rating'      => $this->getReview()['rating'],
                'created'     => $this->getReview()['created'],
                'status'      => $this->viewStatus(),
                'edit_access' => $this->editAccess(),
            ]
        );
    }

    private function editAccess()
    {
        if (
            (
                (int) $this->getReview()['status'] === ForAll::contentStatus()['REVIEW_NOT_PUBLISHED'] &&
                (int) $this->getReview()['author_id'] === Auth::getUserId()
            ) ||
            GroupAccess::check([5])

        ) {
            return true;
        } else {
            return '';
        }
    }
    /**
     * Return actual reviews status or empty string
     * @return string
     */
    private function viewStatus(): string
    {
        if (
            (int) $this->getReview()['author_id'] === Auth::getUserId() ||
            GroupAccess::check([5])
        ) {
            return $this->getReview()['status'];
        } else {
            return '';
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
