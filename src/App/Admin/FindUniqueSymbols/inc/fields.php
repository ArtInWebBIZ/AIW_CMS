<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use App\Admin\FindUniqueSymbols\Req\Select;
use Core\Trl;

defined('AIW_CMS') or die;

return [
    'lang_file'   => [
        'label'       => Trl::_('ADMIN_LANG_FILE'),
        'name'        => 'lang_file',
        'type'        => 'select',
        'clean'       => 'str',
        'disabled'    => false,
        'required'    => true,
        'minlength'   => 2,
        'maxlength'   => 32,
        'check'       => Select::clear(),
        'class'       => 'uk-select',
        'placeholder' => '',
        'value'       => isset($v['lang_file']) ? Select::option($v['lang_file']) : Select::option(),
        'info'        => '',
    ],
];
