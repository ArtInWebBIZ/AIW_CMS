<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Trl};
use Core\Plugins\Select\User\{GroupOption, StatusOption};
use Core\Plugins\Fields\UserFields;
use Core\Plugins\Check\{GroupAccess, IntPageAlias};
use Core\Plugins\Fields\ForAll;

$addFields = require PATH_APP . 'User' . DS . 'Add' . DS . 'inc' . DS . 'fields.php';

$email         = $addFields['email'];
$email['info'] = $email['info'] . '<br><br>' . '<span class="uk-text-danger">' . Trl::_('INFO_IF_USE_INCORRECT_EMAIL_OR_PHONE') . '</span>';

return [
    // 'avatar'      => UserFields::getI()->avatar(isset($v['avatar']) ? $v['avatar'] : ''),
    // 'delete_avatar' => UserFields::getI()->deleteAvatar(isset($v['delete_avatar']) ? $v['delete_avatar'] : ''),
    'name'        => UserFields::getI()->name(isset($v['name']) ? $v['name'] : ''),
    'middle_name' => UserFields::getI()->middleName(isset($v['middle_name']) ? $v['middle_name'] : ''),
    'surname'     => UserFields::getI()->surname(isset($v['surname']) ? $v['surname'] : ''),
    'email'       => $email,
    'phone'       => UserFields::getI()->phone(isset($v['phone']) ? $v['phone'] : ''),
    // 'youtube'     => UserFields::getI()->youtube(isset($v['youtube']) ? $v['youtube'] : ''),
    // 'website'     => UserFields::getI()->website(isset($v['website']) ? $v['website'] : ''),
    // 'soc_net_page' => UserFields::getI()->socNetPage(isset($v['soc_net_page']) ? $v['soc_net_page'] : ''),
    'group'       => ( #
        IntPageAlias::check() !== Auth::getUserId() &&
        GroupAccess::check([5]) &&
        $v['group'] < Auth::getUserGroup()
    ) ? [
        'label'       => Trl::_('USER_GROUP'),
        'name'        => 'group',
        'type'        => 'select',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => true,
        'check'       => GroupOption::getI()->clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['group']) ? GroupOption::getI()->optionToForm($v['group']) : GroupOption::getI()->optionToForm(),
        'info'        => '',
    ] : null,
    'status'      => GroupAccess::check([5]) ? [
        'label'       => Trl::_('USER_STATUS'),
        'name'        => 'status',
        'type'        => 'select',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => true,
        'check'       => StatusOption::getI()->checkToForm(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['status']) ? StatusOption::getI()->optionToForm($v['status']) :
            StatusOption::getI()->optionToForm(),
        'info'        => '',
    ] : null,
];
