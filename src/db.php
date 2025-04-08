<?php

/**
 * @package    ArtInWebCMS.src
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

return [
    'host'     => 'localhost',   // Mandatory parameter!
    'username' => 'root',        // Mandatory parameter! BE SURE TO CHANGE IT
    'password' => '',            // Mandatory parameter! BE SURE TO CHANGE IT
    'db_name'  => 'aiw_cms_db',  // Mandatory parameter! BE SURE TO CHANGE IT
    'charset'  => 'utf-8',       // NOT EDIT !!!
    'view_sql' => 0,             // View ALL sql: 0 - off, 1 - on
];
