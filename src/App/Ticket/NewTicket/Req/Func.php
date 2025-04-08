<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Ticket\NewTicket\Req;

defined('AIW_CMS') or die;

use App\Contacts\Index\Req\Func as CFunc;
use Core\{Auth, Config, Trl};
use Core\Modules\Randomizer;
use Core\Plugins\{Crypt\CryptText, Dll\Ticket, Model\DB, ParamsToSql, Ssl};

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

    public function checkAccess()
    {
        return CFunc::getI()->checkAccess() === 'true' ? true : false;
    }

    private $checkForm = [];

    public function checkForm(): array
    {
        if ($this->checkForm == []) {

            $this->checkForm = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require PATH_APP . 'Contacts' . DS . 'Index' . DS . 'inc' . DS . 'fields.php'
            );
        }

        return $this->checkForm;
    }

    private $saveNewTicket = null;

    public function saveNewTicket(): int
    {
        if ($this->saveNewTicket === null) {

            $this->saveNewTicket = Ticket::getI()->add(
                [
                    'ticket_type' => $this->checkForm()['ticket_type'],
                    'text'        => $this->checkForm()['text'],
                ]
            );
        }

        return $this->saveNewTicket;
    }

    private $createConfirmPayCode = 'null';

    private function createConfirmPayCode()
    {
        if ($this->createConfirmPayCode == 'null') {

            $this->createConfirmPayCode = Randomizer::getRandomStr(
                Config::getCfg('CFG_MIN_REF_CODE_LEN'),
                Config::getCfg('CFG_MAX_REF_CODE_LEN'),
            );
        }

        return $this->createConfirmPayCode;
    }

    private $saveConfirmCode = 'null';

    public function saveConfirmCode()
    {
        if ($this->saveConfirmCode == 'null') {

            $this->saveConfirmCode = DB::getI()->add(
                [
                    'table_name' => 'ticket_confirm_code',
                    'set' => ParamsToSql::getSet(
                        $set = [
                            'ticket_id'    => $this->saveNewTicket(),
                            'confirm_code' => CryptText::getI()->textEncrypt($this->createConfirmPayCode()),
                            'created'      => time(),
                        ]
                    ),
                    'array' => $set,
                ]
            );
        }

        return $this->saveConfirmCode;
    }

    public function sendEmail()
    {
        return (new \Core\Modules\Email)->sendEmail(
            Auth::getUserEmail(),
            Trl::_('EMAIL_CONFIRM_PAY_TO_CARD'),
            Trl::sprintf(
                'EMAIL_CONFIRM_PAY_TO_CARD_TEXT',
                ...[
                    $this->createConfirmPayCode(),
                    Ssl::getLinkLang() . 'ticket/' . $this->saveNewTicket() . '.html',
                    $this->saveNewTicket(),
                    Ssl::getLinkLang() . 'contacts/',
                ]
            )
        );
    }

    public function sendToManagerEmail(string $email)
    {
        return (new \Core\Modules\Email)->sendEmail(
            $email,
            Trl::_('EMAIL_NEW_TICKET_SUBJECT'),
            Trl::sprintf(
                'EMAIL_NEW_TICKET_TEXT',
                ...[
                    Ssl::getLinkLang() . 'ticket/' . $this->saveNewTicket() . '.html',
                    Ssl::getLinkLang() . 'ticket/' . $this->saveNewTicket() . '.html',
                ]
            )
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
