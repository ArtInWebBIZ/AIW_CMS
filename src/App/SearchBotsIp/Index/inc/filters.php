<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\Config;
use Core\Plugins\Fields\Filters;
use Core\Trl;

defined('AIW_CMS') or die;

return [
    'id'     => [
        'label'       => 'ID',
        'name'        => 'id',
        'type'        => 'text',
        'clean'       => 'unsInt',
        'disabled'    => false,
        'required'    => false,
        'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
        'class'       => 'uk-input',
        'placeholder' => '',
        'value'       => isset($v['id']) ? $v['id'] : '',
        'info'        => '',
    ],
    'order_by'    => Filters::getI()->order(isset($v['order_by']) ? $v['order_by'] : ''),
];
