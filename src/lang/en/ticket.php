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

return [
    /**
     * add
     */
    'TICKET_ID'            => 'Ticket ID',
    'TICKET_ADD'           => 'Create a ticket',
    'TICKET_TEXT_POSTED'   => 'The text has been posted',
    'TICKET_ADD_ERROR'     => 'An error occurred while writing the ticket card',
    'TICKET_SUCCESS_SAVED' => 'The ticket for contacting the site administration has been successfully created',
    'TICKET_CONFIRM_CODE'  => 'Confirmation code',

    /**
     * status value
     */
    'TICKET_NOT_CONSIDERED' => 'Not yet considered',
    'TICKET_CONSIDERED'     => 'Under consideration',
    'TICKET_DECIDED'        => 'Decided',
    'TICKET_NOT_DECIDED'    => 'Not decided',
    /**
     * status
     */
    'TICKET_STATUS'                => 'Ticket status',
    'TICKET_STATUS_CHANGE'         => 'Change ticket status',
    'TICKET_STATUS_CHANGE_SUCCESS' => 'The ticket status has been successfully changed',
    'TICKET_STATUS_NO_CHANGE'      => 'No change in ticket status',
    /**
     * type
     */
    'TICKET_TYPE'                      => 'Ticket type',
    'TICKET_TYPE_NOT_SELECTED'         => '- The ticket type is not selected -',
    'TICKET_MESSAGE_TO_SITE_MASTER'    => 'Letter to gid',
    'TICKET_MESSAGE_TO_ADMINISTRATOR'  => 'An email to the administrator',
    'TICKET_MESSAGE_TO_SUPPORT'        => 'Email to technical support',
    'TICKET_USER_DELETE'               => 'Delete user',
    'TICKET_BRING_TO_CARD'             => 'Bring to card',
    /**
     * view
     */
    'TICKET_TITLE'             => 'Ticket',
    'TICKET_NUMBER'            => 'Ticket',
    'TICKET_RESPONSIBLE_ID'    => 'Responsible for the decision',
    'TICKET_OTHER_RESPONSIBLE' => 'Another moderator is responsible for resolving this ticket',
    /**
     * edit
     */
    'TICKET_EDIT_HISTORY'         => 'Ticket edit history',
    'TICKET_TICKETS_EDIT_HISTORY' => 'Ticket edit history',
    'TICKET_ANSWER_FORM'          => 'Answer form',
    /**
     * menu
     */
    'TICKET_CONTROL' => 'Ticket control',
    'TICKET_TICKETS' => 'Tickets',
    /**
     * control
     */
    'TICKET_CREATED_FROM'   => 'Date created - <span class="uk-text-small uk-text-muted">(later than…)</span>',
    'TICKET_CREATED_TO'     => 'Date created - <span class="uk-text-small uk-text-muted">(earlier than…)</span>',
    'TICKET_EDITED_FROM'    => 'Date of edit - <span class="uk-text-small uk-text-muted">(later than…)</span>',
    'TICKET_EDITED_TO'      => 'Date of edit - <span class="uk-text-small uk-text-muted">(earlier than…)</span>',
    'TICKET_NOT_SELECTED'   => 'Ticket status is not selected',
    'TICKET_SELECT_TICKETS' => 'Select tickets',
    /**
     * ticket reply
     */
    'TICKET_ANSWER_ADD'        => 'Add answer',
    'TICKET_ANSWER_TEXT'       => 'Response text',
    'TICKET_NO_ADD_ACCESS_MSG' => 'This ticket has already been completed',
    'TICKET_ADD_ERROR'         => 'Adding a reply to this ticket failed with an error. Please try adding your reply again',
];
