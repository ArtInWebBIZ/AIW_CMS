<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

function debug($data)
{
    echo '<pre>' . print_r($data, true) . '</pre>';
}
