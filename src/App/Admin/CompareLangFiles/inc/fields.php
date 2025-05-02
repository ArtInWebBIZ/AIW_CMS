<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use App\Admin\CompareLangFiles\Req\Select;
use Core\Trl;

defined('AIW_CMS') or die;

return [
    'first_lang'   => [
        'label'       => Trl::_('ADMIN_FIRST_LANG'),
        'name'        => 'first_lang',
        'type'        => 'select',
        'clean'       => 'str', // or 'int', 'unsInt', 'float'
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => 2,
        'maxlength'   => 2,
        'check'       => Select::clear(),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['first_lang']) ? Select::option($v['first_lang']) : Select::option(),
        'info'        => '',
    ],
    'second_lang'   => [
        'label'       => Trl::_('ADMIN_SECOND_LANG'),
        'name'        => 'second_lang',
        'type'        => 'select',
        'clean'       => 'str', // or 'int', 'unsInt', 'float'
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => 2,
        'maxlength'   => 2,
        'check'       => Select::clear(),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['second_lang']) ? Select::option($v['second_lang']) : Select::option(),
        'info'        => '',
    ],
    'file_name'   => [
        'label'       => Trl::_('ADMIN_FILE_NAME'),
        'name'        => 'file_name',
        'type'        => 'select',
        'clean'       => 'str', // or 'int', 'unsInt', 'float'
        'disabled'    => false, // true or false
        'required'    => true, // true or false
        'minlength'   => 2,
        'maxlength'   => 32,
        'check'       => Select::clearFiles(),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['file_name']) ? Select::optionFiles($v['file_name']) : Select::optionFiles(),
        'info'        => '',
    ],
];
