<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

$allUserGroups = require PATH_INC . 'user' . DS . 'group.php';

return [
    'USER_AUTHOR'     => $allUserGroups['USER_AUTHOR'],
    // 'USER_SUPER_USER' => $allUserGroups['USER_SUPER_USER'],
];
