<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Doc\View\Req;

defined('AIW_CMS') or die;

use Core\{Clean, Router};

class Func
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';

    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {
            $this->checkAccess = $this->checkPagePath() != '' ? true : false;
        }

        return $this->checkAccess;
    }

    private function checkPagePath(): string
    {
        $pathFile = PATH_DOC . 'php' . DS . mb_strtolower(Clean::str(Router::getPageAlias())) . '.php';

        return is_readable($pathFile) ? $pathFile : '';
    }

    public function viewDoc()
    {
        return require $this->checkPagePath();
    }

    private function __clone() {}
    public function __wakeup() {}
}
