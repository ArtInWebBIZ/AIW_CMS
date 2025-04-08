<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules;

defined('AIW_CMS') or die;

use Core\Config;

class Email
{
    /**
     * Send email to user
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return boolean
     */
    public function sendEmail(string $to, string $subject, string $message): bool
    {
        $subjectBase64 = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $subjectBase64 = chunk_split($subjectBase64, 70, "\r\n");

        ob_start();
        require PATH_TPL . 'email.php';
        $message = base64_encode(ob_get_clean());
        $message = chunk_split($message, 70, "\r\n");

        return mail(
            $to,
            $subjectBase64,
            $message,
            [
                'MIME-Version'              => '1.0',
                'Content-type'              => 'text/html; charset=utf-8',
                'Content-Transfer-Encoding' => 'base64',
                'From'                      => Config::getCfg('CFG_REPLY_TO_NAME') . ' <' . Config::getCfg('CFG_MAIL_FROM') . '>',
                'Reply-To'                  => Config::getCfg('CFG_MAIL_FROM'),
                'Errors-To'                 => Config::getCfg('CFG_REPLY_TO'),
                'Date'                      => userDate(Config::getCfg('CFG_DATE_TIME_MYSQL_FORMAT'), time()),
            ]
        );
    }
}
