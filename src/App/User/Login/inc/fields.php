<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;
use Core\Trl;

return [
    'login_email'    => [
        'label'       => Trl::_('USER_EMAIL'),
        'name'        => 'login_email',
        'type'        => 'text',
        'clean'       => 'email',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_EMAIL_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_EMAIL_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => '',
        'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf(
            'INFO_USER_EMAIL',
            ...[
                Config::getCfg('CFG_MIN_EMAIL_LEN'),
                Config::getCfg('CFG_MAX_EMAIL_LEN'),
            ]
        ),
    ],
    'login_password' => [
        'label'       => Trl::_('USER_PASSWORD'),
        'name'        => 'login_password',
        'type'        => 'password',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_PASS_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_PASS_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => '',
        'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf('INFO_USER_PASSWORD_DEMANDS', ...[
            Config::getCfg('CFG_MIN_PASS_LEN'),
            Config::getCfg('CFG_MAX_PASS_LEN'),
        ]),
    ],
];
