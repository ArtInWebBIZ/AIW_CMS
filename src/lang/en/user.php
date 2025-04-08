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
    'USER_USERS' => 'Users',
    'USER_MENU'  => 'User menu',
    /**
     * groups
     */
    'USER_GROUP'              => 'User group',
    'USER_GROUP_NOT_SELECTED' => '- The user group is not selected -',
    'USER_GUEST'              => 'Guest',
    'USER_USER'               => 'User',
    'USER_PARTICIPANT'        => 'Participant',
    'USER_MANAGER'            => 'Manager',
    'USER_MODERATOR'          => 'Moderator',
    'USER_SUPER_USER'         => 'Super user',
    'USER_AUTHOR'             => 'Author',
    /**
     * status
     */
    'USER_STATUS'                 => 'User status',
    'USER_STATUS_NOT_SELECTED'    => 'User status is not selected',
    'USER_BLOCK'                  => 'User blocking',
    'USER_NOT_ACTIVATED'          => 'Not activated',
    'USER_ACTIVE'                 => 'Active',
    'USER_BLOCKED'                => 'Blocked',
    'USER_GROUP_DOES_NOT_EXIST'   => 'This user group does not exist',
    'USER_GROUP_NO_ACCESS_TO_REG' => 'You do not have permission to register a user in this group',
    /**
     * add
     */
    'USER_ADD'                           => 'Registration',
    'USER_NAME'                          => 'Name',
    'USER_MIDDLE_NAME'                   => 'Middle name',
    'USER_NAME_YOUR'                     => 'Your name',
    'USER_SURNAME'                       => 'Last name',
    'USER_EMAIL'                         => 'Email',
    'USER_PHONE'                         => 'Phone',
    'USER_AVATAR'                        => 'Logo or avatar',
    'USER_PHONE_YOUR'                    => 'Your phone number',
    'USER_EMAIL_YOUR'                    => 'Your email',
    'USER_EMAIL_ALREADY_EXISTS'          => 'The user with this email address already exists',
    'USER_PHONE_ALREADY_EXISTS'          => 'The user with this phone number already exists',
    'USER_EMAIL_OR_PHONE_ALREADY_EXISTS' => 'The user with this email address or phone number already exists',
    'USER_PASSWORD'                      => 'Password',
    'USER_OLD_PASSWORD'                  => 'Old password',
    'USER_NEW_PASSWORD'                  => 'New password',
    'USER_SEND_NEW_PASSWORD'             => 'Send new password',
    'USER_PASSWORD_CONFIRM'              => 'Confirm your password',
    'USER_NEW_PASSWORD_CONFIRM'          => 'Confirm your new password',
    'USER_NAME_NO_MIN'                   => 'The username cannot be less than %s characters',
    'USER_NAME_NO_MAX'                   => 'The username cannot have more than %s characters',
    'USER_EMAIL_NO_CORRECT'              => 'Invalid email address',
    'USER_EMAIL_NO_MIN'                  => 'The email address cannot be less than %s characters',
    'USER_EMAIL_NO_MAX'                  => 'The email address cannot be more than %s characters',
    'USER_PASSWORD_NO_MIN'               => 'The user password must contain uppercase and lowercase letters of the English alphabet and numbers, but cannot contain less than <strong>%s</strong> characters',
    'USER_PASSWORD_NO_MAX'               => 'The user password must contain uppercase and lowercase letters of the English alphabet and numbers, but cannot contain more than <strong>%s</strong> characters',
    'USER_PASS_NO_CONFIRM'               => 'Passwords do not match',
    'USER_REGISTER_SUCCESS'              => 'Hello!<br><br><strong>Congratulations, you have successfully registered!</strong><br><br>To start using this site, please check the email address you provided during registration and activate your profile: log in to the site using your email and password provided in the email',
    'USER_PLEASE_ACTIVATE_PROFILE'       => 'You are already registered.<br>To start using this site, please check your email and activate your profile: log in using your email and password provided in the email',
    'USER_IN_MENU_ACTIVATE_PROFILE'      => 'To start using this site, check your email and activate your profile: log in to the site using your email and password provided in the email',
    'USER_INCORRECT_ACTIVATION_CODE'     => 'Invalid activation code',
    'USER_CORRECT_ACTIVATION'            => 'Your email address has been verified and your account has been successfully activated',
    'USER_ACTIVATION'                    => 'Activating a user profile',
    'USER_NO_CORRECT_EMAIL_PASSWORD'     => 'Invalid email or password',
    'USER_ADD_END_TIME_SESSION'          => 'The session time for registering a new user has expired. Please try filling out the new user registration form again',
    'USER_NO_CORRECT_ADD'                => 'Your profile was not added correctly, so please try filling out the new user registration form again',
    'USER_BAN_ADD_NEW_USER_FROM_THIS_IP' => 'In order to prevent fraudulent registrations, registration of users from the same IP address is allowed only once every %s hours.<br><br>A new user has already been registered from your IP address recently.<br><br>If it was you, <strong>activate your profile: log in to the site using your email and password specified in the letter</strong>.',

    /**
     * access
     */
    'USER_EDIT'         => 'Edit user',
    'USER_PROFILE'      => 'User profile',
    'USER_EDIT_PROFILE' => 'Edit profile',
    /**
     * login
     */
    'USER_LOGIN'  => 'Login',
    'USER_LOGOUT' => 'Logout',
    /**
     * pass-reset
     */
    'USER_RESET_PASSWORD'              => 'Forgot your password?',
    'USER_SEND_RESET_PASSWORD_SUCCESS' => 'A new password has been successfully sent to the email you provided.<br>To activate the new password, please follow the link provided in the email.<br>The new password will be valid for %s minutes',
    'USER_SENDING_NEW_PASSWORD'        => 'A new password has been sent to the email address you provided',
    'USER_NEW_RESET_PASSWORD_SESSION'  => 'A new password has already been sent to the email you provided.<br>The next new password can only be sent in %s minutes',
    'USER_NO_CORRECT_RESET_CODE'       => 'The new password reset code is incorrect',
    'USER_END_TIME_SESSION'            => 'The session time during which you were sent a new password has now expired.<br>If you still need to receive a new password to access your account, please receive the new password again and activate it <strong>using the same browser and in no more than %s minutes</strong>',
    'USER_RESET_PASSWORD_SUCCESS'      => 'Your new password has been successfully reset and activated.<br>You can log in to your account using your email and new password',
    'USER_CHANGE_PASSWORD_SUCCESS'     => 'Your password has been successfully changed',
    /**
     * profile
     */
    'USER_ID'                    => 'User ID',
    'USER_IP'                    => 'User IP',
    'USER_MODERATORS_ID'         => 'Moderator ID',
    'USER_BEING_EDITED'          => 'This user\'s profile is currently being edited by someone',
    'USER_REGISTRATION_DATE'     => 'Date of registration',
    'USER_EDITED'                => 'Edited',
    'USER_LATEST_VISIT'          => 'Visited the site',
    'USER_REFERRAL_LINK'         => 'Referral link',
    'USER_REFERRAL'              => 'User referral',
    'USER_REFERRALS'             => 'User referrals',
    'USER_REFERRAL_COUNT'        => 'Number of referrals',
    'USER_BALANCE'               => 'User balance',
    'USER_SAVE_TO_BALANCE_ERROR' => 'Your balance has been topped up. However, there was a failure while writing the changes to the user\'s balance to the database. We are aware of this issue and are working hard to resolve it',
    'USER_ADVERTISING'           => 'User advertising',
    /**
     * edit
     */
    'USER_EDIT_HISTORY_USERS' => 'User edit history',
    'USER_EDIT_TIME_OUT'      => 'You cannot edit this user, or the edit time for this user has expired. Please try filling out the edit form again',
    'USER_EDIT_OK'            => 'User profile has been edited',
    'USER_CHANGE_PASSWORD'    => 'Change password',

    'USER_NO_CORRECT_EXTENSION'       => 'Files with this extension cannot be uploaded as a user avatar',
    'USER_INCORRECT_EMAIL_PHONE_DATA' => 'The user profile parameters <strong>Email address</strong> and <strong>Phone</strong> cannot be changed at the same time',
    'USER_EDITED_EMAIL_OR_PHONE_DATA' => 'Your <strong>Email Address</strong> or <strong>Phone Number</strong> has been changed. To confirm your new email address or phone number, please follow the link in the email from our service to your email address',
    /**
     * control
     */
    'USER_CONTROL'            => 'User control',
    'USER_CREATED_FROM'       => 'Date of registration - <span class="uk-text-small uk-text-muted">(later than...)</span>',
    'USER_CREATED_TO'         => 'Date of registration - <span class="uk-text-small uk-text-muted">(earlier than...)</span>',
    'USER_EDITED_FROM'        => 'Date edited - <span class="uk-text-small uk-text-muted">(later than...)</span>',
    'USER_EDITED_TO'          => 'Date edited - <span class="uk-text-small uk-text-muted">(before...)</span>',
    'USER_NOT_SELECTED'       => '- The user is not selected -',
    'USER_SELECT'             => '- Select user',
    'USER_NET'                => 'User network',
    'USER_NET_USERS'          => 'Members of the user\'s network',
    'USER_NET_GENERATED'      => 'Generated',
    'USER_NET_NEXT_GENERATED' => 'The next generation can be created after ',
    /**
     * balance
     */
    'USER_PAID_ID'                => 'Payment ID',
    'USER_PAID_TO'                => 'Recipient',
    'USER_PAID_FROM'              => 'Payer',
    'USER_PAID_SUM'               => 'Payment amount',
    'USER_PAID_TYPE'              => 'Payment type',
    'USER_PAID_TYPE_NOT_SELECTED' => '- Payment type not selected -',
    'USER_PAID_DATE'              => 'Date of payment',
    'USER_ITEM_ID'                => 'Content type ID',
    /**
     * type
     */
    'USER_TYPE'     => 'User type',
    'USER_PERSON'   => 'Person',
    'USER_BUSINESS' => 'Business',
];
