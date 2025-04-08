<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Fields\UserFields;

return [
    'name'        => UserFields::getI()->name(isset($v['name']) ? $v['name'] : ''),
    'email'       => UserFields::getI()->email(isset($v['email']) ? $v['email'] : ''),
    'phone'       => UserFields::getI()->phone(isset($v['phone']) ? $v['phone'] : ''),
];
