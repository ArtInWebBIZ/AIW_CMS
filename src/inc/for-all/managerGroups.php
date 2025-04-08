<?php

defined('AIW_CMS') or die;

$allUserGroups = require PATH_INC . 'user' . DS . 'group.php';

return [
    'USER_AUTHOR'     => $allUserGroups['USER_AUTHOR'],
    'USER_SUPER_USER' => $allUserGroups['USER_SUPER_USER'],
];
