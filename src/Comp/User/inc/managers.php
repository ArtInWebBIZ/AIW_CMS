<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\Plugins\Lib\ForAll;

defined('AIW_CMS') or die;

$allUserGroups = require ForAll::compIncPath('User', 'group');

return [
    'USER_AUTHOR'     => $allUserGroups['USER_AUTHOR'],
    // 'USER_SUPER_USER' => $allUserGroups['USER_SUPER_USER'],
];
