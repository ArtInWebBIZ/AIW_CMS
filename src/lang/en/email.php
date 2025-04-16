<?php

/**
 * @package    ArtInWebCMS.lang
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
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
    'EMAIL_CONFIRM_USER_DELETE'      => 'Confirmation of user delete',
    'EMAIL_CONFIRM_USER_DELETE_TEXT' => 'Confirmation code <strong>%s</strong> for a ticket <strong>#<a href="%s">%s</a></strong>.' . $emailFooter,
    'EMAIL_NEW_LOGIN_SUBJECT'        => 'Log in to the site «ArtInWeb CMS»',
    'EMAIL_NEW_LOGIN_TEXT'           => 'Someone has logged in to the «ArtInWeb CMS» website using your username and password.<br><br><strong>IF IT WAS NOT YOU:</strong><br> urgently change your password to enter the site «ArtInWeb CMS».<br>The form for obtaining a new password is available at the link below.',
    'EMAIL_NEW_REVIEW_SUBJECT'    => 'New review added to the website',
    'EMAIL_NEW_REVIEW_TEXT'       => 'New review added to the website<br><br>Moderate a review:<br><br><a href="%s">%s</a>',
];
