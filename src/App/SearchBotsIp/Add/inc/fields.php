<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Config, Trl};

return [
    'start_range'     => [
        'label'       => Trl::_('SBIP_START'),
        'name'        => 'start_range',
        'type'        => 'text',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => 7,
        'maxlength'   => 15,
        'class'       => 'uk-input',
        'placeholder' => '0.0.0.0',
        'value'       => isset($v['start_range']) ? $v['start_range'] : '',
        'info'        => '',
    ],
    'end_range'     => [
        'label'       => Trl::_('SBIP_END'),
        'name'        => 'end_range',
        'type'        => 'text',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => 7,
        'maxlength'   => 15,
        'class'       => 'uk-input',
        'placeholder' => '0.0.0.0',
        'value'       => isset($v['end_range']) ? $v['end_range'] : '',
        'info'        => '',
    ],
    'engine_name'     => [
        'label'       => Trl::_('SBIP_ENGINE_NAME'),
        'name'        => 'engine_name',
        'type'        => 'text',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_NAME_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_NAME_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['engine_name']) ? $v['engine_name'] : '',
        'info'        => '',
    ],
];
