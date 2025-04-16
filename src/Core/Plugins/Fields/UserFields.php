<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Fields;

defined('AIW_CMS') or die;

use Core\{Trl, Config};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Select\User\Type;

class UserFields
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): UserFields
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Get users parent_id or null
     * @param string $value
     * @return mixed
     */
    public function parentId(string $value): mixed
    {
        return GroupAccess::check([5]) ? [
            'label'       => Trl::_('USER_REFERRAL'),
            'name'        => 'parent_id',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => '',
        ] : null;
    }
    /**
     * Get User Name
     * @param string $value
     * @return array
     */
    public function name(string $value): array
    {
        return [
            'label'       => Trl::_('USER_NAME'),
            'name'        => 'name',
            'type'        => 'text',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_NAME_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_NAME_LEN'),
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('EXAMPLE_USER_NAME'),
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf(
                'INFO_USER_NAME',
                ...[
                    Config::getCfg('CFG_MIN_NAME_LEN'),
                    Config::getCfg('CFG_MAX_NAME_LEN'),
                ]
            ),
        ];
    }
    /**
     * Add or edit user middle_name
     * @param string $value
     * @return array
     */
    public function middleName(string $value): array
    {
        return [
            'label'       => Trl::_('USER_MIDDLE_NAME'),
            'name'        => 'middle_name',
            'type'        => 'text',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_NAME_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_NAME_LEN'),
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('EXAMPLE_USER_LASTNAME'),
            'value'       => $value,
            'info'        => Trl::sprintf(
                'INFO_USER_LASTNAME',
                ...[
                    Config::getCfg('CFG_MIN_NAME_LEN'),
                    Config::getCfg('CFG_MAX_NAME_LEN'),
                ]
            ),
        ];
    }
    /**
     * Add or edit user surname
     * @param string $value
     * @return array
     */
    public function surname(string $value): array
    {
        return [
            'label'       => Trl::_('USER_SURNAME'),
            'name'        => 'surname',
            'type'        => 'text',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_NAME_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_NAME_LEN'),
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('EXAMPLE_USER_SURNAME'),
            'value'       => $value,
            'info'        => Trl::sprintf(
                'INFO_USER_SURNAME',
                ...[
                    Config::getCfg('CFG_MIN_NAME_LEN'),
                    Config::getCfg('CFG_MAX_NAME_LEN'),
                ]
            ),
        ];
    }
    /**
     * Add or edit user email
     * @param string $value
     * @return array
     */
    public function email(string $value): array
    {
        return [
            'label'       => Trl::_('USER_EMAIL'),
            'name'        => 'email',
            'type'        => 'email',
            'clean'       => 'email',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_EMAIL_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_EMAIL_LEN'),
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('EXAMPLE_EMAIL'),
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf(
                'INFO_USER_EMAIL_DEMANDS',
                ...[
                    Config::getCfg('CFG_MIN_EMAIL_LEN'),
                    Config::getCfg('CFG_MAX_EMAIL_LEN'),
                ]
            ),
        ];
    }
    /**
     * Add or edit user phone
     * @param string $value
     * @return array
     */
    public function phone(string $value): array
    {
        return [
            'label'       => Trl::_('USER_PHONE'),
            'name'        => 'phone',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_USER_PHONE_LEN') - 3,
            'maxlength'   => Config::getCfg('CFG_USER_PHONE_LEN') + 1,
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('EXAMPLE_USER_PHONE'),
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::_('INFO_USER_PHONE'),
        ];
    }
    /**
     * Get field select user type
     * @param string $value
     * @return array
     */
    public function type(string $value): array
    {
        return [
            'label'       => Trl::_('USER_TYPE'),
            'name'        => 'type',
            'type'        => 'select',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'check'       => Type::getI()->clear(),
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? Type::getI()->option($value) : Type::getI()->option(),
            'info'        => '',
        ];
    }

    private function __clone() {}
    public function __wakeup() {}
}
