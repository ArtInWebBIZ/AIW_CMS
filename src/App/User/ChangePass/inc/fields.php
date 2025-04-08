<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, Trl};

return [
    'old_password'     => [
        'label'       => Trl::_('USER_OLD_PASSWORD'),
        'name'        => 'old_password',
        'type'        => 'password',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_PASS_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_PASS_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => '',
        'info'        => '',
    ],
    'new_password'     => [
        'label'       => Trl::_('USER_NEW_PASSWORD'),
        'name'        => 'new_password',
        'type'        => 'password',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_PASS_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_PASS_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => '',
        'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::sprintf('INFO_USER_PASSWORD_DEMANDS', ...[
            Config::getCfg('CFG_MIN_PASS_LEN'),
            Config::getCfg('CFG_MAX_PASS_LEN'),
        ]),
    ],
    'password_confirm' => [
        'label'       => Trl::_('USER_NEW_PASSWORD_CONFIRM'),
        'name'        => 'password_confirm',
        'type'        => 'password',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_PASS_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_PASS_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => '',
        'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::sprintf('INFO_USER_PASSWORD_DEMANDS', ...[
            Config::getCfg('CFG_MIN_PASS_LEN'),
            Config::getCfg('CFG_MAX_PASS_LEN'),
        ]),
    ],
];
