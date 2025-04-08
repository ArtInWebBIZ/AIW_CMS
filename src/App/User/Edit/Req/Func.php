<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\Edit\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Config, GV};
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\{ParamsToSql, Msg, Model\DB, Crypt\CryptText, View\Tpl};
use Core\Plugins\Check\{GroupAccess, IntPageAlias};
use Core\Plugins\Dll\ForAll;
use Core\Plugins\View\Style;

class Func
{
    private static $instance    = null;
    private $checkFormValues    = [];
    private $compareUserProfile = [];
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
    public function checkFormValues(): array
    {
        if ($this->checkFormValues == []) {

            $this->checkFormValues = (new \Core\Plugins\Check\FormFields)->getCheckFields(
                require ForAll::contIncPath() . 'fields.php'
            );
        }

        return $this->checkFormValues;
    }
    /**
     * Return only changed user profile values
     * @return mixed // array or null
     */
    public function compareUserProfile(): mixed
    {
        if ($this->compareUserProfile == []) {

            $this->compareUserProfile = null;

            $formValues  = $this->checkFormValues();
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

                    $this->compareUserProfile[$key] = $formValues[$key];

                    if ($key == 'email') {
                        $this->compareUserProfile['status'] = 0;
                    }

                    if ($key == 'group' && $value == 4) {
                        $this->compareUserProfile['parent_id'] = 0;
                    }
                }
            }

            if (
                isset($this->compareUserProfile['email']) &&
                isset($this->compareUserProfile['phone'])
            ) {
                $this->compareUserProfile['msg'] = Msg::getMsg_('warning', 'USER_INCORRECT_EMAIL_PHONE_DATA');
            }
        }

        return $this->compareUserProfile;
    }
    /**
     * Update current users profile
     * @return boolean
     */
    public function updateEditedUserProfile(): bool
    {
        $changedValues = $this->compareUserProfile();

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
        $editedValues = $this->compareUserProfile();

        if (isset($editedValues['email_encrypt'])) {
            unset($editedValues['email_hash'], $editedValues['email_encrypt']);
        }

        if (isset($editedValues['phone_encrypt'])) {
            unset($editedValues['phone_hash'], $editedValues['phone_encrypt']);
        }

        foreach ($editedValues as $key => $value) {

            $return = false;

            if ($key == 'email') {
                $oldValue = '***** old email *****';
                $newValue = '***** new email *****';
            } elseif ($key == 'phone') {
                $oldValue = '***** old phone *****';
                $newValue = '***** new phone *****';
            } else {
                $oldValue = $this->getCustomUser()[$key];
                $newValue = $editedValues[$key];
            }

            $params = [
                'edited_id'    => $this->getCustomUser()['id'],
                'editor_id'    => Auth::getUserId(),
                'edited_field' => $key,
                'old_value'    => $oldValue,
                'new_value'    => $newValue,
                'edited'       => time(),
            ];

            $logId = 0;

            $logId = DB::getI()->add(
                [
                    'table_name' => 'user_edit_log',
                    'set'        => ParamsToSql::getSet($params),
                    'array'      => $params,
                ]
            );

            if ($logId > 0) {
                $return = true;
            } else {
                break;
            }
        }

        return $return;
    }
    /**
     * Return users edit form
     * @return string
     */
    public function viewForm(): string
    {
        $v = [
            'id'          => $this->getCustomUser()['id'],
            'parent_id'   => $this->getCustomUser()['parent_id'],
            'group'       => $this->getCustomUser()['group'],
            'status'      => $this->getCustomUser()['status'],
            'name'        => $this->getCustomUser()['name'],
            'middle_name' => $this->getCustomUser()['middle_name'],
            'surname'     => $this->getCustomUser()['surname'],
            'type'        => $this->getCustomUser()['type'],
            'email'       => $this->getCustomUser()['email'],
            'phone'       => $this->getCustomUser()['phone'] == $this->getCustomUser()['ref_code'] ? '' : $this->getCustomUser()['phone'],
            'youtube'     => $this->getCustomUser()['youtube'],
            'website'     => $this->getCustomUser()['website'],
            'soc_net_page' => $this->getCustomUser()['soc_net_page'],
            'created'     => userDate(Config::getCfg('CFG_DATE_TIME_MYSQL_FORMAT'), $this->getCustomUser()['created']),
        ];

        $vImage = $this->getCustomUser()['avatar'] != '' ?
            '/' . Config::getCfg('CFG_USER_AVATAR_PATH') . '/' .
            date("Y", $this->getCustomUser()['created']) . '/' .
            date("m", $this->getCustomUser()['created']) . '/' .
            date("d", $this->getCustomUser()['created']) . '/' .
            $this->getCustomUser()['id'] . '/' . $this->getCustomUser()['avatar'] : null;

        return Tpl::view(
            PATH_TPL . 'view' . DS . 'formView.php',
            [
                'enctype'             => true, // false or true
                'section_css'         => Style::form()['section_css'],
                'container_css'       => Style::form()['container_css'], // container style
                'overflow_css'        => Style::form()['overflow_css'],
                'h_margin'            => Style::form()['h_margin'], // title style
                'button_div_css'      => Style::form()['button_div_css'], // buttons div style
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h1', // title weight
                'title'               => 'USER_EDIT',
                'url'                 => 'user/edit/' . IntPageAlias::check() . '.html',
                'cancel_url'          => 'user/' . IntPageAlias::check() . '.html', // or '/controller/action/'
                'v_image'             => $vImage, // or image path
                'fields'              => require PATH_APP . 'User' . DS . 'Edit' . DS . 'inc' . DS . 'fields.php',
                'button_label'        => 'USER_EDIT',
                'include_after_form'  => '', // include after form
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
                    'array'      => ['email_hash' => GetHash::getDefHash($this->compareUserProfile()['email'])],
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
                    'array'      => ['phone_hash' => GetHash::getDefHash($this->compareUserProfile()['phone'])],
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
                    $this->compareUserProfile['msg'] = $this->saveAvatar['msg'];
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
