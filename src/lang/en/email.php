<?php

/**
 * @package    ArtInWebCMS.lang
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

/**
 * !!! Everything inside HTML tags is NOT TRANSLATED !!!
 */

$emailFooter = '<br><br><hr style="border:none; border-bottom:1px solid gold"><br><span style="display:block; font-size:x-small; text-align:center">If your email address was not specified by you during any actions on the site, please inform the site administration on the page <a href="%s">Contacts</a></span>';

return [
    'EMAIL_CONFIRM'                  => 'Confirm your email address',
    'EMAIL_CONFIRM_NEW_EMAIL'        => '<b>Greetings</b>!<br><br>To confirm your new email address, log in to the website:<br><br><a href="%s">%s</a>' . $emailFooter,
    'EMAIL_CONFIRM_NEW_PHONE'        => '<b>Greetings</b>!<br><br>To confirm your new phone number, log in to the website:<br><br><a href="%s">%s</a>' . $emailFooter,
    'EMAIL_CREATE_NEW_USER'          => '<b>Greetings</b>!<br><br>To activate your account, log in to the site using the password below.<br><br><a href="%s">%s</a><br><br>Your password to log in to the site: <strong>%s</strong>' . $emailFooter,
    'EMAIL_SEND_NEW_PASSWORD'        => 'Your new password: <b>%s</b><br><br>To activate a new password in your account, follow the link below:<br><br><a href="%s">%s</a><br><br>If you did not request a new password <strong>DO NOT CLICK ON THE GIVEN LINK</strong>! In this case, your old password will remain valid.' . $emailFooter,
    'EMAIL_NEW_TICKET_SUBJECT'       => 'New ticket created',
    'EMAIL_NEW_TICKET_TEXT'          => 'New ticket created – <a href="%s">#%s</a>.<br>',
    'EMAIL_NEW_ANSWER_TICKET_SUBJECT' => 'Added a new reply to the ticket',
    'EMAIL_NEW_ANSWER_TICKET_TEXT'    => 'Added a new reply to the ticket – <a href="%s">#%s</a>.<br>',
    'EMAIL_CONFIRM_PAY_TO_CARD'      => 'Confirmation of withdrawals',
    'EMAIL_CONFIRM_PAY_TO_CARD_TEXT' => 'Confirmation code <strong>%s</strong> for a ticket <strong>#<a href="%s">%s</a></strong>.' . $emailFooter,
    'EMAIL_ERROR_SAVE_TO_USERS_BALANCE_SUBJECT' => 'Error while recording a user\'s balance replenishment',
    'EMAIL_ERROR_SAVE_TO_USERS_BALANCE_TEXT' => 'An error occurred at one of the three stages while recording the replenishment of user\'s #%s balance:<br>- writing a new value to the user\'s profile balance;<br>- logging changes to the user profile;<br>- recording changes to the user\'s balance log.',
    'EMAIL_NEW_LOGIN_SUBJECT'        => 'Log in to the site «Portugal inside out»',
    'EMAIL_NEW_LOGIN_TEXT'           => 'Someone has logged in to the «Portugal inside out» website using your username and password.<br><br>If it was not you:<br> <strong>urgently change your password to enter the site «Portugal inside out»</strong>.<br>The form for obtaining a new password is available at the link below.',
    'EMAIL_BALANCE_STAGE_SUBJECT'    => 'The new amount is accumulated on your balance sheet',
    'EMAIL_BALANCE_STAGE_TEXT'       => 'You have an accumulated amount on your balance equal to or greater than %s %s',
    'EMAIL_NEW_REVIEW_SUBJECT'    => 'New review added to the website',
    'EMAIL_NEW_REVIEW_TEXT'       => 'New review added to the website<br><br>Moderate a review:<br><br><a href="%s">%s</a>',
];
