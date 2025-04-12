<?php

/**
 * @package    ArtInWebCMS.src
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

spl_autoload_register(function (string $class) {

    $class = str_replace('\\', DS, $class);

    $namespace = explode("\\", __NAMESPACE__);

    $pathNamespace = '';

    foreach ($namespace as $key => $value) {
        $pathNamespace .= $namespace[$key] . DS;
    }

    $path = PATH_BASE . $pathNamespace . $class . '.php';

    if (is_readable($path)) {
        require $path;
    }
});
