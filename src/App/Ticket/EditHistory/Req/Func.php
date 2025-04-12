<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Ticket\EditHistory\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Dll\ForAll;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

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
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() == 1
            ) {
                $this->checkAccess =  true;
            }
        }

        return $this->checkAccess;
    }

    private $extra = null;

    public function extra(): array
    {
        if ($this->extra === null) {

            if (GroupAccess::check([2])) {

                $this->extra = [
                    'ticket_type' => [
                        'sql'            => '`ticket_type` = :ticket_type AND ',
                        'filters_values' => ForAll::valueFromKey('ticket', 'type')['TICKET_MESSAGE_TO_SITE_MASTER'],
                    ],
                ];
                #
            } elseif (GroupAccess::check([1])) {
                /**
                 * Get all id users tickets
                 * @return array // array or []
                 */
                $idList = DB::getI()->getNeededField(
                    [
                        'table_name'          => 'ticket',
                        'field_name'          => 'id', // example 'id' or 'id`,`edited_count`,`brand_status'
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

                if ($idList != []) {

                    $id = [];

                    foreach ($idList as $key => $value) {
                        $id[] = $idList[$key]['id'];
                    }

                    $itemId = ParamsToSql::getInSql($id);

                    $this->extra = [
                        'ticket_id' => [
                            'sql'            => '`ticket_id` ' . $itemId['in'] . ' AND ',
                            'filters_values' => $itemId['array'],
                        ],
                    ];
                    #
                } else {

                    $this->extra = [
                        'id' => [
                            'sql'            => '`id` = :id AND ',
                            'filters_values' => 0,
                        ],
                    ];
                }
                #
            } else {
                $this->extra = [];
            }
        }

        return $this->extra;
    }

    private function __clone() {}
    public function __wakeup() {}
}
