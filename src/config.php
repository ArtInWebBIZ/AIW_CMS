<?php

/**
 * @package    ArtInWebCMS.src
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

return [
    'salt_one'    => 'BE_SURE_TO_CHANGE_IT', // Mandatory parameter! BE SURE TO CHANGE IT !!!!!!!
    'salt_two'    => 'BE_SURE_TO_CHANGE_IT', // Mandatory parameter! BE SURE TO CHANGE IT !!!!!!!
    'hash_method' => 'sha384',               // Mandatory parameter! 96 symbols
    'http_type'   => 'http://',              // Mandatory parameter! BE SURE TO CHANGE IT !!!!!!!
    'site_host'   => 'artinweb.cms',         // Mandatory parameter! BE SURE TO CHANGE IT !!!!!!!
];
