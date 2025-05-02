<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Trl, Config, Languages};
use Core\Plugins\Fields\Filters;

$lang = count(Languages::langCodeList()) > 1 ?
    [
        'label'       => Trl::_('OV_LANG'),
        'name'        => 'lang',
        'type'        => 'text',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['lang']) ? $v['lang'] : '',
        'info'        => '',
    ] : null;

return [
    'lang'           => $lang,
    'url_id'           => [
        'label'       => Trl::_('LABEL_LINK'),
        'name'        => 'url_id',
        'type'        => 'text',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['url_id']) ? $v['url_id'] : '',
        'info'        => '',
    ],
    'user_id'           => [
        'label'       => Trl::_('USER_ID'),
        'name'        => 'user_id',
        'type'        => 'text',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['user_id']) ? $v['user_id'] : '',
        'info'        => '',
    ],
    'user_ip'           => [
        'label'       => Trl::_('USER_IP'),
        'name'        => 'user_ip',
        'type'        => 'text',
        'clean'       => 'int',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['user_ip']) ? $v['user_ip'] : '',
        'info'        => '',
    ],
    'created_from'    => Filters::getI()->createdFrom(isset($v['created_from']) ? $v['created_from'] : ''),
    'created_to'      => Filters::getI()->createdTo(isset($v['created_to']) ? $v['created_to'] : ''),
    'order_by'        => Filters::getI()->order(isset($v['order_by']) ? $v['order_by'] : ''),
];
