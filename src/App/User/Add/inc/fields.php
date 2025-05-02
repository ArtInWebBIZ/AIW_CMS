<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Comp\User\Lib\Fields;

return [
    'name'  => Fields::getI()->name(isset($v['name']) ? $v['name'] : ''),
    'email' => Fields::getI()->email(isset($v['email']) ? $v['email'] : ''),
    // 'type'  => UserFields::getI()->type(isset($v['type']) ? $v['type'] : ''),
];
