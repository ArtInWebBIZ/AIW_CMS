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
    'clean_html' => [
        'label'       => Trl::_('ADMIN_CLEAN_HTML'),
        'name'        => 'clean_html',
        'type'        => 'textarea',
        'clean'       => 'text',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_TEXT_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_TEXT_LEN'),
        'class'       => 'uk-textarea',
        'rows'        => Config::getCfg('CFG_TEXTAREA_ROWS'),
        'placeholder' => '',
        'value'       => isset($v['clean_html']) ? $v['clean_html'] : '',
        'info'        => '',
    ],
];
