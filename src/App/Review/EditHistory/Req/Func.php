<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Review\EditHistory\Req;

defined('AIW_CMS') or die;

use Core\{Auth};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $extra           = null;

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
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() == 1
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Return …
     * @return array
     */
    public function extra(): array
    {
        if ($this->extra === null) {

            if (GroupAccess::check([2, 5])) {
                $this->extra = [];
            } else {
                /**
                 * Get id users review
                 */
                $reviewId = DB::getI()->getNeededField(
                    [
                        'table_name'          => 'review',
                        'field_name'          => 'id',
                        'where'               => ParamsToSql::getSql(
                            $where = ['author_id' => Auth::getUserId()]
                        ),
                        'array'               => $where,
                        'order_by_field_name' => 'id',
                        'order_by_direction'  => 'ASC', // DESC
                        'offset'              => 0,
                        'limit'               => 0, // 0 - unlimited
                    ]
                );

                if ($reviewId != []) {

                    $id = [];

                    foreach ($reviewId as $key => $value) {
                        $id[] = $reviewId[$key]['id'];
                    }
                    unset($key, $value);

                    $in = ParamsToSql::getInSql($id);

                    $this->extra = [
                        'edited_id' => [
                            'sql'            => '`edited_id` ' . $in['in'] . ' AND ',
                            'filters_values' => $in['array'],
                        ],
                    ];
                    #
                } else {

                    $this->extra = [
                        'id' => [
                            'sql'            => '`id` = :id  AND ',
                            'filters_values' => 0,
                        ],
                    ];
                }
            }
        }

        return $this->extra;
    }
    #

    private function __clone() {}
    public function __wakeup() {}
}
