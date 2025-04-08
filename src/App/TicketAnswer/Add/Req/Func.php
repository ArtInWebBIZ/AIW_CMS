<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\TicketAnswer\Add\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Clean, GV, Trl};
use Core\Plugins\{ParamsToSql, Model\DB, Check\Item, Ssl, Crypt\CryptText, Check\GroupAccess};
use Core\Plugins\Dll\ForAll;

class Func
{
    private static $instance = null;
    private $ticket          = [];
    private $checkPost       = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function checkAccess()
    {
        if (Auth::getUserId() > 0) {

            if (
                Auth::getUserStatus() == 1 &&
                (
                    (int) $this->checkTicket()['author_id'] === Auth::getUserId() ||
                    GroupAccess::check([5])
                ) &&
                (int) $this->checkTicket()['ticket_status'] === ForAll::valueFromKey('ticket', 'status')['TICKET_CONSIDERED']
            ) {
                return true;
            }
            #
        } else {
            return false;
        }
    }
    /**
     * @return mixed // array or false
     */
    public function checkTicket()
    {
        if ($this->ticket == []) {

            $this->ticket = DB::getI()->getRow(
                [
                    'table_name' => 'ticket',
                    'where'      => ParamsToSql::getSql(
                        $where = ['id' => Clean::int(GV::post()['ticket_id'])]
                    ),
                    'array'      => $where,
                ]
            );;
        }

        return $this->ticket;
    }

    private $addAnswer = 'null';

    public function addAnswer()
    {
        if ($this->addAnswer == 'null') {

            $this->addAnswer = DB::getI()->add(
                [
                    'table_name' => 'ticket_answer',
                    'set'        => ParamsToSql::getSet(
                        $set = [
                            'ticket_id' => $this->checkTicket()['id'],
                            'author_id' => Auth::getUserId(),
                            'answer'    => $this->checkPost()['answer'],
                            'created'   => time(),
                        ]
                    ),
                    'array'      => $set,
                ]
            );
        }

        return $this->addAnswer;
    }

    public function toEnlargeAnswerCount()
    {
        return DB::getI()->update(
            [
                'table_name' => 'ticket',
                'set'        => '`answer_count` = `answer_count` + 1',
                'where'      => '`id` = :id',
                'array'      => ['id' => $this->checkTicket()['id']],
            ]
        );
    }

    public function checkPost()
    {
        if ($this->checkPost === null) {
            $this->checkPost = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require ForAll::contIncPath() . 'fields.php'
            );
        }

        return $this->checkPost;
    }

    public function sendAnswersEmail()
    {
        if (Auth::getUserId() === (int) $this->checkTicket()['author_id']) {
            $sendToEmail = $this->sendToEmail($this->checkTicket()['responsible']);
        } else {
            $sendToEmail = $this->sendToEmail($this->checkTicket()['author_id']);
        }

        return (new \Core\Modules\Email)->sendEmail(
            $sendToEmail,
            Trl::_('EMAIL_NEW_ANSWER_TICKET_SUBJECT'),
            Trl::sprintf(
                'EMAIL_NEW_ANSWER_TICKET_TEXT',
                ...[
                    Ssl::getLinkLang() . 'ticket/' . $this->checkTicket()['id'] . '.html',
                    $this->checkTicket()['id'],
                ]
            )
        );
    }

    private function sendToEmail(int $userId): string
    {
        $sendToEmail = DB::getI()->getValue(
            [
                'table_name' => 'user',
                'select'     => 'user',
                'where'      => ParamsToSql::getSql($where = ['id' => $userId]),
                'array'      => $where,
            ]
        );

        $sendToEmail = json_decode($sendToEmail, true);

        return CryptText::getI()->textDecrypt($sendToEmail['email']);
    }

    private function __clone() {}
    public function __wakeup() {}
}
