<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Fields\UserFields;

return [
    'name'  => UserFields::getI()->name(isset($v['name']) ? $v['name'] : ''),
    'email' => UserFields::getI()->email(isset($v['email']) ? $v['email'] : ''),
    // 'type'  => UserFields::getI()->type(isset($v['type']) ? $v['type'] : ''),
];
