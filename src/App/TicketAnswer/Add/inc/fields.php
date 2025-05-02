<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Config;

return [
    'ticket_id' => [
        'label'       => '',
        'name'        => 'ticket_id',
        'type'        => 'hidden',
        'clean'       => 'unsInt',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => '',
        'maxlength'   => '',
        'class'       => '',
        'placeholder' => '',
        'value'       => isset($v['ticket_id']) ? $v['ticket_id'] : '',
        'info'        => '',
    ],
    'answer'    => [
        'label'       => '',
        'name'        => 'answer',
        'type'        => 'textarea',
        'clean'       => 'text',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => Config::getCfg('CFG_MIN_TICKET_ANSWER_LEN'),
        'maxlength'   => Config::getCfg('CFG_MAX_TICKET_ANSWER_LEN'),
        'class'       => 'uk-textarea',
        'rows'        => Config::getCfg('CFG_TEXTAREA_ROWS'),
        'placeholder' => '',
        'value'       => '',
        'info'        => '',
    ],
];
