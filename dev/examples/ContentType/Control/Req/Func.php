<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ContentType\Control\Req;

defined('AIW_CMS') or die;

use Core\Content;

class Func
{
    private static $instance = null;
    private $defPageParams   = null;
    private $checkAccess = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check user`s access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {
            $this->checkAccess = false;
        }

        return $this->checkAccess;
    }
    /**
     * Return actual page params
     * @return array
     */
    public function defPageParams(): array
    {
        if ($this->defPageParams === null) {

            // ALL VALUES IS EXAMPLE  !!! CHANGE_THIS !!!

            $this->defPageParams                  = Content::getDefaultValue();
            $this->defPageParams['robots']        = 'index, follow';
            $this->defPageParams['sitemap_order'] = 2;
            $this->defPageParams['title']         = 'EXAMPLE_TITLE';
            #
        }

        return $this->defPageParams;
    }

    private function __clone() {}
    public function __wakeup() {}
}
