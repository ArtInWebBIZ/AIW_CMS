<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Edit\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Config, GV};
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\{ParamsToSql, Msg, Model\DB, Crypt\CryptText, View\Tpl};
use Core\Plugins\Check\{CheckForm, GroupAccess, IntPageAlias};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Style;

class Func
{
    private static $instance    = null;
    private $checkForm    = [];
    private $checkEditedFields = [];
    private $checkAccess        = 'null';
    private $getCustomUser      = [];
    private $checkNewUserEmail  = 'null';
    private $checkNewUserPhone  = 'null';
    private $saveAvatar         = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check users access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                IntPageAlias::check() !== false &&
                $this->getCustomUser() !== false &&
                Auth::getUserId() > 0 &&
                Auth::getUserStatus() == 1 &&
                (
                    Auth::getUserId() === IntPageAlias::check() ||
                    GroupAccess::check([3, 5])
                )
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * @return mixed // array or false
     */
    public function getCustomUser(): mixed
    {
        if ($this->getCustomUser === []) {

            $this->getCustomUser = Auth::getCustomUser(IntPageAlias::check());

            if ($this->getCustomUser !== false) {

                $user = json_decode($this->getCustomUser['user'], true);

                $this->getCustomUser['name']        = $user['name'] != '' ? CryptText::getI()->textDecrypt($user['name']) : '';
                $this->getCustomUser['middle_name'] = $user['middle_name'] != '' ? CryptText::getI()->textDecrypt($user['middle_name']) : '';
                $this->getCustomUser['surname']     = $user['surname'] != '' ? CryptText::getI()->textDecrypt($user['surname']) : '';
                $this->getCustomUser['phone']       = CryptText::getI()->textDecrypt($user['phone']);
                $this->getCustomUser['email']       = CryptText::getI()->textDecrypt($user['email']);
                $this->getCustomUser['avatar']      = isset($user['avatar']) ? $user['avatar'] : '';
                $this->getCustomUser['youtube']     = isset($user['youtube']) ? $user['youtube'] : '';
                $this->getCustomUser['website']     = isset($user['website']) ? $user['website'] : '';
                $this->getCustomUser['soc_net_page'] = isset($user['soc_net_page']) ? $user['soc_net_page'] : '';

                unset($this->getCustomUser['user'], $user);
            }
        }

        return $this->getCustomUser;
    }
    /**
     * Return corrected form values
     * or error message
     * @return array
     */
    public function checkForm(): array
    {
        if ($this->checkForm == []) {
            $this->checkForm = CheckForm::check(ForAll::contIncPath() . 'fields.php');
        }

        return $this->checkForm;
    }
    /**
     * Return only changed user profile values
     * @return mixed // array or null
     */
    public function checkEditedFields(): mixed
    {
        if ($this->checkEditedFields == []) {

            $this->checkEditedFields = null;

            $formValues  = $this->checkForm();
            $userProfile = $this->getCustomUser();

            if (
                isset($formValues['delete_avatar']) &&
                $formValues['delete_avatar'] == 1
            ) {
                $formValues['avatar'] = '';
            }
            unset($formValues['delete_avatar']);

            if ($formValues['phone'] == '') {
                $formValues['phone'] = $userProfile['ref_code'];
            }

            if (
                isset($formValues['avatar']) &&
                is_array($formValues['avatar']) &&
                $this->saveAvatar() != []
            ) {
                $formValues['avatar'] = $this->saveAvatar()['file_name'];
            }

            foreach ($formValues as $key => $value) {

                if (
                    $formValues[$key] == $userProfile[$key]
                ) {
                    continue;
                } else {

                    $this->checkEditedFields[$key] = $formValues[$key];

                    if ($key == 'email') {
                        $this->checkEditedFields['status'] = 0;
                    }

                    if ($key == 'group' && $value == 4) {
                        $this->checkEditedFields['parent_id'] = 0;
                    }
                }
            }

            if (
                isset($this->checkEditedFields['email']) &&
                isset($this->checkEditedFields['phone'])
            ) {
                $this->checkEditedFields['msg'] = Msg::getMsg_('warning', 'USER_INCORRECT_EMAIL_PHONE_DATA');
            }
        }

        return $this->checkEditedFields;
    }
    /**
     * Update current users profile
     * @return boolean
     */
    public function updateEditedUserProfile(): bool
    {
        $changedValues = $this->checkEditedFields();

        $countChangedValues = count($changedValues);

        if (
            isset($changedValues['name']) ||
            isset($changedValues['middle_name']) ||
            isset($changedValues['surname']) ||
            isset($changedValues['email']) ||
            isset($changedValues['phone']) ||
            isset($changedValues['avatar']) ||
            isset($changedValues['youtube']) ||
            isset($changedValues['website']) ||
            isset($changedValues['soc_net_page'])
        ) {

            $changedValues['user'] = json_encode(
                [
                    'name'         => CryptText::getI()->textEncrypt(isset($changedValues['name']) ? $changedValues['name'] : $this->getCustomUser()['name']),
                    'middle_name'  => CryptText::getI()->textEncrypt(isset($changedValues['middle_name']) ? $changedValues['middle_name'] : $this->getCustomUser()['middle_name']),
                    'surname'      => CryptText::getI()->textEncrypt(isset($changedValues['surname']) ? $changedValues['surname'] : $this->getCustomUser()['surname']),
                    'email'        => CryptText::getI()->textEncrypt(isset($changedValues['email']) ? $changedValues['email'] : $this->getCustomUser()['email']),
                    'phone'        => CryptText::getI()->textEncrypt(isset($changedValues['phone']) ? $changedValues['phone'] : $this->getCustomUser()['phone']),
                    'avatar'       => isset($changedValues['avatar']) ? $changedValues['avatar'] : $this->getCustomUser()['avatar'],
                    'youtube'      => isset($changedValues['youtube']) ? $changedValues['youtube'] : $this->getCustomUser()['youtube'],
                    'website'      => isset($changedValues['website']) ? $changedValues['website'] : $this->getCustomUser()['website'],
                    'soc_net_page' => isset($changedValues['soc_net_page']) ? $changedValues['soc_net_page'] : $this->getCustomUser()['soc_net_page'],
                ]
            );

            if (isset($changedValues['email'])) {
                $changedValues['email_hash'] = GetHash::getEmailHash($changedValues['email']);
                $changedValues['status'] = 0;
            }

            if (isset($changedValues['phone'])) {
                $changedValues['phone_hash'] = GetHash::getDefHash($changedValues['phone']);
                $changedValues['status'] = 0;
            }

            unset(
                $changedValues['name'],
                $changedValues['middle_name'],
                $changedValues['surname'],
                $changedValues['email'],
                $changedValues['phone'],
                $changedValues['avatar'],
                $changedValues['youtube'],
                $changedValues['website'],
                $changedValues['soc_net_page'],
            );
        }

        $changedValues['edited']       = time();
        $changedValues['edited_count'] = $this->getCustomUser()['edited_count'] + $countChangedValues;

        return DB::getI()->update(
            [
                'table_name' => 'user',
                'set'        => ParamsToSql::getSet($changedValues),
                'where'      => '`id` = :id',
                'array'      => array_merge($changedValues, ['id' => $this->getCustomUser()['id']]),
            ]
        );
    }
    /**
     * Save edited users fields to edit log
     * @return bool
     */
    public function saveUserEditToLog(): bool
    {
        $return = false;

        $editedValues = $this->checkEditedFields();

        if (isset($editedValues['email_encrypt'])) {
            unset($editedValues['email_hash'], $editedValues['email_encrypt']);
        }

        if (isset($editedValues['phone_encrypt'])) {
            unset($editedValues['phone_hash'], $editedValues['phone_encrypt']);
        }

        $valueToLog = [];

        foreach ($editedValues as $key => $value) {

            if ($key == 'email') {
                $oldValue = '*** old email ***';
                $newValue = '*** new email ***';
            } elseif ($key == 'phone') {
                $oldValue = '*** old phone ***';
                $newValue = '*** new phone ***';
            } else {
                $oldValue = $this->getCustomUser()[$key];
                $newValue = $editedValues[$key];
            }

            $valueToLog[] = [
                'edited_id'    => $this->getCustomUser()['id'],
                'editor_id'    => Auth::getUserId(),
                'edited_field' => $key,
                'old_value'    => $oldValue,
                'new_value'    => $newValue,
                'edited'       => time(),
            ];
        }
        unset($key, $value);

        $return = DB::getI()->insertInto(
            'user_edit_log',
            $valueToLog

        );

        return $return;
    }
    /**
     * Return users edit form
     * @return string
     */
    public function viewForm(): string
    {
        $v = [];

        foreach ($this->getCustomUser() as $key => $value) {
            $v[$key] = $value;
        }

        $v['phone'] = $v['phone'] == $v['ref_code'] ? '' : $v['phone'];

        $vImage = $v['avatar'] != '' ?
            '/' . Config::getCfg('CFG_USER_AVATAR_PATH') . '/' .
            date("Y", $v['created']) . '/' .
            date("m", $v['created']) . '/' .
            date("d", $v['created']) . '/' .
            $v['id'] . '/' . $v['avatar'] : null;

        $v['created'] = userDate(Config::getCfg('CFG_DATE_TIME_MYSQL_FORMAT'), $v['created']);

        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'             => true,
                'section_css'         => Style::form()['section_css'],
                'container_css'       => Style::form()['container_css'],
                'overflow_css'        => Style::form()['overflow_css'],
                'h_margin'            => Style::form()['h_margin'],
                'button_div_css'      => Style::form()['button_div_css'],
                'submit_button_style' => '',
                'button_id'           => '',
                'h'                   => 'h1',
                'title'               => 'USER_EDIT',
                'url'                 => 'user/edit/' . IntPageAlias::check() . '.html',
                'cancel_url'          => 'user/' . IntPageAlias::check() . '.html',
                'v_image'             => $vImage,
                'fields'              => require ForAll::contIncPath() . 'fields.php',
                'button_label'        => 'USER_EDIT',
                'include_after_form'  => '',
            ]
        );
    }
    /**
     * Check new users email
     * @return integer // value or zero (0)
     */
    public function checkNewUserEmail(): int
    {
        if ($this->checkNewUserEmail === 'null') {

            $this->checkNewUserEmail = (int) DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'id',
                    'where'      => '`email_hash` = :email_hash',
                    'array'      => ['email_hash' => GetHash::getDefHash($this->checkEditedFields()['email'])],
                ]
            );
        }

        return $this->checkNewUserEmail;
    }
    /**
     * Check new users phone
     * @return mixed // value or zero (0)
     */
    public function checkNewUserPhone()
    {
        if ($this->checkNewUserPhone == 'null') {

            $this->checkNewUserPhone = (int) DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'id',
                    'where'      => '`phone_hash` = :phone_hash',
                    'array'      => ['phone_hash' => GetHash::getDefHash($this->checkEditedFields()['phone'])],
                ]
            );
        }

        return $this->checkNewUserPhone;
    }
    /**
     * Return avatar or logo name or error message in key ['msg']
     * @return array // or []
     */
    public function saveAvatar(): array
    {
        if ($this->saveAvatar === null) {

            if (
                isset(GV::files()['avatar']) &&
                GV::files()['avatar']['error'] == (int) 0 &&
                (int) GV::files()['avatar']['size'] < Config::getCfg('CFG_MAX_IMAGES_SIZE')
            ) {
                /**
                 * Save new users logo or avatar
                 */
                $this->saveAvatar = (new \Core\Plugins\Upload\OneImage)->uploadImage(
                    [
                        'form_value'       => GV::files(), // Get form values
                        'input_name'       => 'avatar', // Get images files
                        'items_date'       => $this->getCustomUser()['created'], // 
                        'dir_name'         => Config::getCfg('CFG_USER_AVATAR_PATH'), // 
                        'items_id_or_code' => $this->getCustomUser()['id'], // 
                        'img_width'        => Config::getCfg('CFG_AVATAR_SIDE_SIZE'), // 
                        'img_height'       => Config::getCfg('CFG_AVATAR_SIDE_SIZE'), // 
                    ]
                );
                /**
                 * View error message
                 */
                if (isset($this->saveAvatar['msg'])) {
                    $this->checkEditedFields['msg'] = $this->saveAvatar['msg'];
                    $this->saveAvatar = [];
                }
                #
            } else {
                $this->saveAvatar = [];
            }
        }

        return $this->saveAvatar;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
