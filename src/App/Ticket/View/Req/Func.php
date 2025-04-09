<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Ticket\View\Req;

defined('AIW_CMS') or die;

use Core\Modules\Pagination\Pagination;
use Core\Plugins\{View\Tpl, Name\TicketType, Name\TicketStatus, Model\DB, Dll\Ticket, Crypt\CryptText, Check\Item,};
use Core\{Trl, GV, Config, Clean, Auth, BaseUrl};
use Core\Plugins\Check\{GroupAccess, IntPageAlias};
use Core\DB as DbCore;

class Func
{
    private $ticketId          = 'null';
    private $allStatusChange   = [];
    private $select            = '';
    private static $instance   = null;
    private $ticketAnswersList = 'null';
    private $countAnswersId    = 'null';
    private $getTicketsAuthor  = [];

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';

    public function checkAccess()
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() == 1 &&
                (
                    ($this->getTicket()['author_id'] == Auth::getUserId()
                    ) ||
                    ((int) $this->getTicket()['ticket_type'] === 3 &&
                        GroupAccess::check([2])
                    ) ||
                    (in_array((int) $this->getTicket()['ticket_type'], [4, 5, 6], true) &&
                        GroupAccess::check([5])
                    )
                )

            ) {

                return true;
            }
        }

        return $this->checkAccess;
    }

    public function getTicketId()
    {
        if ($this->ticketId === 'null') {
            $this->ticketId = is_int(IntPageAlias::check()) ? IntPageAlias::check() : 0;
        }

        return $this->ticketId;
    }

    private $getTicket = 'null';

    public function getTicket()
    {
        if ($this->getTicket == 'null') {

            $this->getTicket = Ticket::getI()->getTicket(['id' => $this->getTicketId()]);
        }

        return $this->getTicket;
    }

    public function checkTicketKey()
    {
        if (
            Clean::str(GV::get()['ticket_key']) == $this->getTicket()['ticket_key']
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function viewTicket()
    {
        /**
         * Получаем ID ответственного модератора или администратора за решение данного тикета
         */
        if ($this->getTicket()['responsible'] > 0) {
            $ticketResponsible = '<a href="' . 'user/' . $this->getTicket()['responsible'] . '.html">' . $this->getTicket()['responsible'] . '</a>';
        } else {
            $ticketResponsible = $this->getTicket()['responsible'];
        }
        /**
         * Если статус тикета был отредактирован, указываем дату редактирования
         */
        if (
            GroupAccess::check([3, 4, 5]) &&
            $this->getTicket()['edited'] != $this->getTicket()['created']
        ) {
            $ticketEdited = userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $this->getTicket()['edited']);
        } else {
            $ticketEdited = '';
        }
        /**
         * Если статус тикета был изменён,
         * указываем ссылку на профиль редактора
         */
        if ($this->getTicket()['editor_id'] > 0) {
            $ticketEditorId = '<a href="' . 'user/' . $this->getTicket()['editor_id'] . '.html">' . $this->getTicket()['editor_id'] . '</a>';
        } else {
            $ticketEditorId = '';
        }
        /**
         * Показываем форму для изменения статуса только для пользователей
         * группы "Модератор" и выше
         */
        if (GroupAccess::check([5])) {
            $ticketChangeStatusForm = Tpl::view(
                PATH_APP . 'Ticket' . DS . 'View' . DS . 'inc' . DS . 'ticketChangeStatusForm.php',
                ['select' => $this->getSelect()]
            );
        } else {
            $ticketChangeStatusForm = '';
        }
        /**
         * Get Tickets confirm code
         */
        if (
            ((int) $this->getTicket()['ticket_type'] === 1 ||
                (int) $this->getTicket()['ticket_type'] === 6
            ) &&
            Auth::getUserGroup() > 3
        ) {
            $ticketConfirmCode = CryptText::getI()->textDecrypt(
                DB::getI()->getValue(
                    [
                        'table_name' => 'ticket_confirm_code',
                        'select'     => 'confirm_code',
                        'where'      => '`id` = :id',
                        'array'      => ['id' => $this->getTicket()['id']],
                    ]
                )
            );
        } else {
            $ticketConfirmCode = '';
        }

        $authorsBalance = (int) $this->getTicket()['ticket_type'] === 1 && GroupAccess::check([4]) ? $this->getTicketsAuthor()['balance'] : '';

        return Tpl::view(
            PATH_APP . 'Ticket' . DS . 'View' . DS . 'inc' . DS . 'view.php',
            [
                'author_id'                 => $this->getTicket()['author_id'],
                'ticket_id'                 => $this->getTicket()['id'],
                'author_name'               => $this->getTicketAuthorName(),
                'ticket_type'               => TicketType::getTypeName($this->getTicket()['ticket_type']),
                'ticket_status'             => TicketStatus::getColor($this->getTicket()['ticket_status']),
                'ticket_responsible'        => $ticketResponsible,
                'ticket_created'            => userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $this->getTicket()['created']),
                'ticket_edited'             => $ticketEdited,
                'ticket_editor_id'          => $ticketEditorId,
                'ticket_confirm_code'       => $ticketConfirmCode,
                'users_balance'             => $authorsBalance,
                'ticket_text'               => $this->getTicket()['text'],
                'answer_form'               => $this->viewAnswerForm(),
                'ticket_change_status_form' => $this->ticketAnswersList() != '' ? $ticketChangeStatusForm : '',
                'ticket_answers_list'       => $this->ticketAnswersList(),
                'answers_pagination'        => Pagination::getPagination($this->countAnswersId(), Config::getCfg('CFG_PAGINATION')),
            ]
        );
    }

    private function getTicketsAuthor()
    {
        if ($this->getTicketsAuthor == []) {

            $this->getTicketsAuthor = DB::getI()->getNeededField(
                [
                    'table_name'          => 'user',
                    'field_name'          => 'user`,`balance',
                    'where'               => '`id` = :id',
                    'array'               => ['id' => $this->getTicket()['author_id']],
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => 'ASC',
                    'offset' => 0,
                    'limit'               => 1,
                ]
            );

            if ($this->getTicketsAuthor === []) {

                $this->getTicketsAuthor = [
                    'name'    => 'John',
                    'surname' => 'Dow',
                    'balance' => 0,
                ];
            } else {

                $user     = $this->getTicketsAuthor[0];
                $userName = json_decode($user['user'], true);

                $this->getTicketsAuthor = [
                    'name'    => $userName['name'] != '' ? CryptText::getI()->textDecrypt($userName['name']) : '',
                    'surname' => $userName['surname'] != '' ? CryptText::getI()->textDecrypt($userName['surname']) : '',
                    'balance' => $user['balance'],
                ];

                unset($user, $userName);
            }
        }

        return $this->getTicketsAuthor;
    }

    private function getTicketAuthorName()
    {
        return $this->getTicketsAuthor()['name'] == '' ?
            Trl::_('USER_USER') . ' #' . $this->getTicket()['author_id'] :
            $this->getTicketsAuthor()['name'] . ' ' . $this->getTicketsAuthor()['surname'];
    }

    private function getSelect()
    {
        if ($this->select == '') {

            $this->select = '<select name="ticket_status" id="ticket_status" class="uk-select">
            <option  disabled>' . Trl::_('OV_SELECT_VALUE') . '</option>';

            foreach ($this->getAllChangedTicketStatus() as $key => $value) {
                $selected = $this->getTicket()['ticket_status'] == $value ? ' selected="selected"' : '';
                $this->select .= '<option value="' . $value . '"' . $selected . '>' . Trl::_($key) . '</option>';
            }

            $this->select .= '</select>';
        }

        return $this->select;
    }

    public function getAllChangedTicketStatus()
    {
        if ($this->allStatusChange == []) {

            $allStatusChange = require PATH_INC . 'ticket' . DS . 'status.php';

            if (GroupAccess::check([3])) {
                unset($allStatusChange['TICKET_NOT_CONSIDERED'], $allStatusChange['TICKET_CONSIDERED']);
            } elseif (GroupAccess::check([4, 5])) {
                unset($allStatusChange['TICKET_NOT_CONSIDERED']);
            }

            $this->allStatusChange = $allStatusChange;
        }

        return $this->allStatusChange;
    }

    public function changeTicketStatus()
    {
        return Ticket::getI()->updateTicket(
            [
                'set'   => [
                    'edited'        => time(),
                    'editor_id'     => Auth::getUserId(),
                    'ticket_status' => 1,
                ],
                'where' => ['id' => $this->getTicketId()],
            ]
        );
    }

    public function changeTicketResponsible()
    {
        return Ticket::getI()->updateTicket(
            [
                'set'   => ['responsible' => Auth::getUserId()],
                'where' => ['id' => $this->getTicketId()],
            ]
        );
    }

    public function saveChangeStatusToLog()
    {
        return Ticket::getI()->saveToEditLog(
            [
                'ticket_id'    => $this->getTicketId(),
                'ticket_type'  => $this->getTicket()['ticket_type'],
                'editor_id'    => Auth::getUserId(),
                'edited_field' => 'ticket_status',
                'old_value'    => 0,
                'new_value'    => 1,
                'edited'       => time(),
            ]
        );
    }

    private function viewAnswerForm()
    {
        if ($this->getTicket()['ticket_status'] == 1) {

            $v['ticket_id'] = $this->getTicket()['id'];

            return Tpl::view(
                PATH_TPL . 'view' . DS . 'formView.php',
                [
                    'enctype'      => false, // false or true
                    'title'        => null, // or null
                    'section_css'     => 'uk-padding-remove',
                    'overflow_css' => '',
                    'url'          => 'ticket-answer/add/',
                    'cancel_url'   => 'hidden', // or '/controller/action/' or 'hidden'
                    'v_image'      => null, // or image path
                    'fields'       => require PATH_APP . 'TicketAnswer' . DS . 'Add' . DS . 'inc' . DS . 'fields.php',
                    'button_label' => 'TICKET_ANSWER_ADD',
                ]
            );
        } else {

            return '';
        }
    }

    private function ticketAnswersList()
    {
        if ($this->ticketAnswersList === 'null') {
            /**
             * If there are answers
             */
            if ($this->countAnswersId() > 0) {
                /**
                 * Get response IDs
                 */
                $neededItemsId = $this->getNeededItemsId(
                    [
                        'table_name'          => 'ticket_answer',
                        'where'               => '`ticket_id` = :ticket_id',
                        'array'               => ['ticket_id' => $this->getTicket()['id']],
                        'order_by_field_name' => 'id',
                        'order_by_direction'  => 'ASC', // DESC
                        'offset'              => Pagination::checkStartGet(),
                        'limit'               => Config::getCfg('CFG_PAGINATION'),
                    ]
                );
                /**
                 * Get ticket responses in an associative array
                 */
                $neededItems = $this->getNeededItems(
                    [
                        'table_name' => 'ticket_answer',
                        'items_id'   => $neededItemsId,
                        'order_by'   => 'ASC',
                    ]
                );

                $this->ticketAnswersList = '';

                foreach ($neededItems as $key2 => $value2) {

                    $this->ticketAnswersList .= Tpl::view(
                        PATH_APP . 'Ticket' . DS . 'View' . DS . 'inc' . DS . 'ticketAnswersList.php',
                        [
                            'created'     => userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), $neededItems[$key2]['created']),
                            'author_id'   => '<a href="' . 'user/' . $neededItems[$key2]['author_id'] . '.html">' . $neededItems[$key2]['author_id'] . '</a>',
                            'answer_text' => $neededItems[$key2]['answer'],
                        ]
                    );
                }

                unset($neededItemsId, $neededItems);
            } else {
                $this->ticketAnswersList = '';
            }
        }

        return $this->ticketAnswersList;
    }

    public function getNeededItemsId($params)
    {
        $neededItemsIdArray = DB::getI()->getNeededField(
            [
                'table_name'          => $params['table_name'],
                'field_name'          => 'id',
                'where'               => $params['where'],
                'array'               => $params['array'],
                'order_by_field_name' => $params['order_by_field_name'],
                'order_by_direction'  => $params['order_by_direction'],
                'offset'              => $params['offset'],
                'limit'               => $params['limit'],
            ]
        );

        foreach ($neededItemsIdArray as $key => $value) {
            $itemsId[$key] = $neededItemsIdArray[$key]['id'];
        }

        return implode(",", $itemsId);
    }

    public function getNeededItems($params)
    {
        $tableName = $params['table_name'];
        $itemsId   = $params['items_id'];
        $orderBy   = $params['order_by'];

        $itemsList = DbCore::getAll(
            "SELECT * FROM `$tableName`
            WHERE `id` IN ($itemsId)
            ORDER BY `id` $orderBy",
            []
        );

        foreach ($itemsList as $key => $value) {
            $id         = $itemsList[$key]['id'];
            $items[$id] = $itemsList[$key];
        }

        return $items;
    }

    private function countAnswersId()
    {
        if ($this->countAnswersId == 'null') {

            $this->countAnswersId = (int) DB::getI()->countFields(
                [
                    'table_name' => 'ticket_answer',
                    'field_name' => 'id',
                    'where'      => '`ticket_id` = :ticket_id',
                    'array'      => [
                        'ticket_id' => $this->getTicket()['id'],
                    ],
                ]
            );
        }

        return $this->countAnswersId;
    }

    private function __clone() {}
    public function __wakeup() {}
}
