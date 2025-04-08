<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Dll;

defined('AIW_CMS') or die;

use Core\{Auth, Session};
use Core\Modules\Randomizer;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

class Ticket
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Ticket
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Add new ticket to database
     * @param array $params
     * @return integer
     */
    public function add(array $params): int
    {
        $ticketId = DB::getI()->add(
            [
                'table_name' => 'ticket',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'ticket_type' => $params['ticket_type'],
                        'author_id'   => Auth::getUserId(),
                        'text'        => $params['text'],
                        'lang'        => Session::getLang(),
                        'created'     => time(),
                        'edited'      => time(),
                    ]
                ),
                'array'      => $set,
            ]
        );

        if ($ticketId > 0) {

            $this->saveToEditLog(
                [
                    'ticket_id'    => $ticketId,
                    'editor_id'    => Auth::getUserId(),
                    'edited_field' => 'ticket_status',
                    'old_value'    => '',
                    'new_value'    => ForAll::valueFromKey('ticket', 'status')['TICKET_NOT_CONSIDERED'],
                    'edited'       => time(),
                ]
            );
        }

        return $ticketId;
    }
    /**
     * Save edited tickets value to tickets edit log
     * @param array $params
     * @return integer
     */
    public function saveToEditLog(array $params): int
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
     * @return array|false
     */
    public function getTicket(array $params): array|bool
    {
        return DB::getI()->getRow(
            [
                'table_name' => 'ticket',
                'where'      => ParamsToSql::getSqlOr($params),
                'array'      => $params,
            ]
        );
    }
    /**
     * Save to ticket new params
     * @param array $params
     * @return boolean
     */
    public function updateTicket(array $params): bool
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

    private function __clone() {}
    public function __wakeup() {}
}
