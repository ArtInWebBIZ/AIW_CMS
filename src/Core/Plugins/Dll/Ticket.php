<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Dll;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Modules\Randomizer;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Session;

class Ticket
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getI(): Ticket
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function add(array $params)
    {
        $params = [
            'ticket_type' => $params['ticket_type'],
            'author_id'   => Auth::getUserId(),
            'text'        => $params['text'],
            'lang'        => Session::getLang(),
            'created'     => time(),
            'edited'      => time(),
        ];

        $ticketId = DB::getI()->add(
            [
                'table_name' => 'ticket',
                'set'        => ParamsToSql::getSet($params),
                'array'      => $params,
            ]
        );

        $this->saveToEditLog(
            [
                'ticket_id'    => $ticketId,
                'editor_id'    => Auth::getUserId(),
                'edited_field' => 'ticket_status',
                'old_value'    => '',
                'new_value'    => 0,
                'edited'       => time(),
            ]
        );

        return $ticketId;
    }

    public function setTicketKey()
    {
        do {
            $ticketKey = Randomizer::getRandomStr(32, 32);
            $a         = DB::getI()->getValue([
                'table_name' => 'ticket',
                'select'     => 'id',
                'where'      => '`ticket_key` = :ticket_key',
                'array'      => ['ticket_key' => $ticketKey],
            ]);
        } while ($a !== null);

        return $ticketKey;
    }

    public function saveToEditLog(array $params)
    {
        return DB::getI()->add(
            [
                'table_name' => 'ticket_edit_log',
                'set'        => ParamsToSql::getSet($params),
                'array'      => $params,
            ]
        );
    }

    /**
     * Get ticket
     * @param array $params
     * @return mixed array | false
     */
    public function getTicket(array $params)
    {
        return DB::getI()->getRow(
            [
                'table_name' => 'ticket',
                'where'      => ParamsToSql::getSqlOr($params),
                'array'      => $params,
            ]
        );
    }

    public function getLatestTicketId(array $params)
    {
        return DB::getI()->getMaxValue(
            [
                'table_name' => 'ticket',
                'field_name' => 'id',
                'where'      => ParamsToSql::getSql($params),
                'array'      => $params,
            ]
        );
    }

    public function updateTicket(array $params)
    {
        return DB::getI()->update(
            [
                'table_name' => 'ticket',
                'set'        => ParamsToSql::getSet($params['set']),
                'where'      => ParamsToSql::getSql($params['where']),
                'array'      => array_merge($params['set'], $params['where']),
            ]
        );
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
