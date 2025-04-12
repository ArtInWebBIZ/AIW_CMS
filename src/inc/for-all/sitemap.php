<?php

defined('AIW_CMS') or die;

/**
 * 0 - noindex, nofollow
 */

$robots = require PATH_INC . 'for-all' . DS . 'robots.php';

return [
    'Main' => [
        'Index' => [
            'order'     => 1,
            'robots'    => $robots[1],
            'cash_time' => 300
        ],
    ],
    'Doc' => [
        'View' => [
            'order'     => 7,
            'robots'    => $robots[2],
            'cash_time' => 604800
        ],
    ],
    'Blog' => [
        'Index' => [
            'order'     => 4,
            'robots'    => $robots[1],
            'cash_time' => true
        ],
        'View' => [
            'order'     => 10,
            'robots'    => $robots[2],
            'cash_time' => 604800
        ],
    ],
    'Review' => [
        'Index' => [
            'order'     => 5,
            'robots'    => $robots[1],
            'cash_time' => 3600
        ],
        'View' => [
            'order'     => 11,
            'robots'    => $robots[2],
            'cash_time' => 604800
        ],
    ],
    'Contacts' => [
        'Index' => [
            'order'     => 6,
            'robots'    => $robots[2],
            'cash_time' => 604800
        ],
    ],
];
