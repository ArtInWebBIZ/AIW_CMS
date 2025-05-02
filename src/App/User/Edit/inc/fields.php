<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\User\Lib\Fields;
use Comp\User\Lib\Select\{Group, Status};
use Core\{Auth, Trl};
use Core\Plugins\Check\{GroupAccess, IntPageAlias};

$addFields = require PATH_APP . 'User' . DS . 'Add' . DS . 'inc' . DS . 'fields.php';

$email         = $addFields['email'];
$email['info'] = $email['info'] . '<br><br>' . '<span class="uk-text-danger">' . Trl::_('INFO_IF_USE_INCORRECT_EMAIL_OR_PHONE') . '</span>';

return [
    // 'avatar'      => Fields::getI()->avatar(isset($v['avatar']) ? $v['avatar'] : ''),
    // 'delete_avatar' => Fields::getI()->deleteAvatar(isset($v['delete_avatar']) ? $v['delete_avatar'] : ''),
    'name'        => Fields::getI()->name(isset($v['name']) ? $v['name'] : ''),
    'middle_name' => Fields::getI()->middleName(isset($v['middle_name']) ? $v['middle_name'] : ''),
    'surname'     => Fields::getI()->surname(isset($v['surname']) ? $v['surname'] : ''),
    'email'       => $email,
    'phone'       => Fields::getI()->phone(isset($v['phone']) ? $v['phone'] : ''),
    // 'youtube'     => Fields::getI()->youtube(isset($v['youtube']) ? $v['youtube'] : ''),
    // 'website'     => Fields::getI()->website(isset($v['website']) ? $v['website'] : ''),
    // 'soc_net_page' => Fields::getI()->socNetPage(isset($v['soc_net_page']) ? $v['soc_net_page'] : ''),
    'group'       => (
        IntPageAlias::check() !== Auth::getUserId() &&
        GroupAccess::check([5])
    ) ? [
        'label'       => Trl::_('USER_GROUP'),
        'name'        => 'group',
        'type'        => 'select',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => true,
        'check'       => Group::getI()->clear(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['group']) ? Group::getI()->optionToForm($v['group']) : Group::getI()->optionToForm(),
        'info'        => '',
    ] : null,
    'status'      => GroupAccess::check([5]) ? [
        'label'       => Trl::_('USER_STATUS'),
        'name'        => 'status',
        'type'        => 'select',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => true,
        'check'       => Status::getI()->checkToForm(),
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['status']) ? Status::getI()->optionToForm($v['status']) :
            Status::getI()->optionToForm(),
        'info'        => '',
    ] : null,
];
