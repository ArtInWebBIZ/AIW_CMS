<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;
use Core\Config;

return [
    'email'     => [
        'label'       => Trl::_('USER_EMAIL_YOUR'),
        'name'        => 'email',
        'type'        => 'text',
        'clean'       => 'email',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_EMAIL_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_EMAIL_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['email']) ? $v['email'] : '',
        'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::_('INFO_PASSRESET'),

    ]
];
