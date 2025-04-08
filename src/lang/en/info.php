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
    'INFO_USER_PASSWORD_DEMANDS'     => 'The user password may contain numbers, uppercase and lowercase letters of the English alphabet, but not less than <strong>%s</strong>, and no more <strong>%s</strong> symbols.',
    'INFO_USER_EMAIL'                => 'User email address <em>(email)</em> must contain at least <strong>%s</strong>, and no more <strong>%s</strong> symbols.',
    'INFO_USER_EMAIL_DEMANDS'        => '<strong><span class="uk-text-danger">Only enter the email address that you ACTUALLY use!</span><br><br>If you do not activate your account using the email address provided here <em>(email)</em>, you <span class="uk-text-danger">YOU WILL NOT BE ABLE TO</span> use this website in any way, except for viewing publicly available public information.</strong><br><br>User email address <em>(email)</em> must contain at least <strong>%s</strong>, and no more <strong>%s</strong> symbols.',
    'INFO_USER_NAME'                 => '<strong>In this field, enter NAME ONLY</strong>&nbsp;!<br><br>The name can contain at least <strong>%s</strong> and no more <strong>%s</strong> symbols.',
    'INFO_USER_LASTNAME'             => 'Your middle name.<br><br>Your middle name may contain at least <strong>%s</strong> and no more <strong>%s</strong> symbols.',
    'INFO_USER_SURNAME'              => 'Your surname.<br><br>The surname may contain at least <strong>%s</strong> and no more <strong>%s</strong> symbols.',
    'INFO_DEPARTMENT_NUMBER'      => 'The department number.<br><br>Department number <strong>must consist only of numbers</strong>, may contain no less than <strong>%s</strong> and no more <strong>%s</strong> characters and <strong>cannot be equal to 0</strong>.',
    'INFO_DEPARTMENT_ADDRESS'     => 'Address of the department.<br><br>Department address <strong>(region, district of the region, city (town, village), street and house number)</strong>. The address of the department may contain at least <strong>%s</strong> and no more <strong>%s</strong> symbols.',
    'INFO_USER_PHONE'                => '<strong>Your phone number.</strong><br><br>Phone number may contain <strong>ONLY NUMBERS</strong>, <em>including the Country code <strong>(without a "+" sign)</strong></em>, without spaces and other symbols.',
    'INFO_ARCHIVE_LINK'              => 'Link to the archive with photos.<br><br>The link to the archive with photos may contain at least <strong>%s</strong> and no more  <strong>%s</strong> symbols.<br><br>Place an archive with your photos on your <a href="https://drive.google.com/drive/my-drive" target="_blank" rel="noopener noreferrer">Google-drive</a>, provide access to it, and post a link to this archive here.<br><br>Or, send an archive with your photos to our <a href="https://t.me/photosbizua" target="_blank" rel="noopener noreferrer">Telegram</a>, and in this field just write <strong>telegram</strong>.<br><br><strong>!!! IT IS NECESSARY TO ARCHIVE PHOTOS !!!</strong>',
    'INFO_USER_PHONE_ACCESS'         => 'Your phone number is protected by <a href="/doc/privacy-policy.html">"Privacy Policy"</a> of our website.<br><br><strong>Your phone number can be seen only by you and the site administration to clarify the details of the order, payment, delivery, etc.</strong>.',
    'INFO_USER_EMAIL_ACCESS'         => 'Your email address is protected by <a href="/doc/privacy-policy.html">"Privacy Policy"</a> of our website.<br><br><strong>Only you can see your email</strong>.<br><br>Your email on this site is used <strong>solely for the purpose of recovery</strong> (or change) <strong>password</strong> to log in to this site.<br><br><span class="uk-text-danger">Please note that if you provide an email address, <strong>WHICH DOES NOT EXIST</strong>, or this, <strong>to which you do not have access, You will NOT be able to restore access to your account on this site</strong></span>.',
    'INFO_NO_CORRECT_FIELD_VALUE'    => 'Invalid field value ',
    'INFO_CLEAR_FILTERS'             => 'Clean filters',
    'INFO_INCORRECT_DOWNLOAD_IMAGE'  => 'Image uploaded with errors',
    'INFO_INCORRECT_IMAGE_SIZE'      => 'The size (weight) of the uploaded image exceeds the permissible size',
    'INFO_INCORRECT_IMAGE_EXTENSION' => 'Invalid file type to be uploaded',
    'INFO_IMAGE_NOT_DOWNLOAD'        => 'Image was not uploaded',
    'INFO_COUNT_10X15_PHOTO'         => 'Number of photos <strong>10х15</strong> sm.<br><br>Total number of photos 10х15 sm. can have <strong>only digits</strong>. A number cannot consist of less than <strong>%s</strong>, and no more than <strong>%s</strong> digits.<br><br>The cost of one photo format 10х15 sm. is <strong>%s</strong> UAH.<br><br>If you do not order photos of this size, put <strong>0</strong>.',
    'INFO_COUNT_13X18_PHOTO'         => 'Number of photos <strong>13х18</strong> sm.<br><br>Total number of photos 13х18 sm. can have <strong>only digits</strong>. A number cannot consist of less than <strong>%s</strong>, and no more than <strong>%s</strong> digits.<br><br>The cost of one photo format 13х18 sm. is <strong>%s</strong> UAH.<br><br>If you do not order photos of this size, put <strong>0</strong>.',
    'INFO_COUNT_A4_PHOTO'            => 'Number of photos <strong>A4</strong>.<br><br>Total number of photos A4 can have <strong>only digits</strong>. A number cannot consist of less than <strong>%s</strong>, and no more than <strong>%s</strong> digits.<br><br>The cost of one photo format A4 is <strong>%s</strong> UAH.<br><br>If you do not order photos of this size, put <strong>0</strong>.',
    'INFO_CROP_PHOTO'                => '<strong>Cropping photos</strong><br><br>Cropping is a manual selection by the editor of the best photo plot in accordance with the proportions of the paper on which the photo will be printed.',
    'INFO_PASSRESET'                 => 'The email address you provided when registering on this site.',
    'INFO_IF_USE_INCORRECT_EMAIL_OR_PHONE' => 'If you specify an <strong>INCORRECT</strong> "Email address" or "Phone" - your access to this site may be closed by you <strong>FOREVER!</strong',
    'INFO_TO_CHOOSE_A_PHOTO' => '<strong>Add a photo to the order</strong><br><br>To select multiple photos on your computer at once, press the <strong><em>«Ctrl»</em></strong>. On smartphones, tap and hold a photo, and then select the photos you want to see one by one.<br><br><strong>It is optimal to add up to 5 photos at a time.</strong>',
    'INFO_COPIES_AMOUNT' => '<strong>Number of copies</strong><br><br>Specify how many copies of each photo you want to print from the currently uploaded photos.',
];
