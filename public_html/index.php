<?php

/**
 * @package    ArtInWebCMS.public_html
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

define('MINIMUM_PHP', '8.0');

if (version_compare(PHP_VERSION, MINIMUM_PHP, '<=')) {
    die('Your host needs to use PHP ' . MINIMUM_PHP . ' or higher to run this sites version');
}
/**
 * Uncomment the following lines if the site is under reconstruction
 */
// require_once __DIR__ . DIRECTORY_SEPARATOR . 'sur.php';
// die;

define('AIW_CMS', 1);
define('DS', DIRECTORY_SEPARATOR);
define('PATH_PUBLIC', __DIR__ . DS);

require '..' . DS . 'src' . DS . 'autoload.php';

use Core\{ErrorHandler, App};

ErrorHandler::getI()->register();

App::render();

exit;
