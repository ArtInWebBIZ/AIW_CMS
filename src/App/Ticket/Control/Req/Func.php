<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Ticket\Control\Req;

defined('AIW_CMS') or die;

use Core\Plugins\Check\GroupAccess;
use Core\{Auth};
use Core\Plugins\Dll\ForAll;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $extra           = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check current users access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() == 1 && GroupAccess::check([5])
            ) {

                $this->checkAccess =  true;
                #
            }
        }

        return $this->checkAccess;
    }
    /**
     * Undocumented function
     * @return array
     */
    public function extra(): array
    {
        if ($this->extra === null) {

            if (GroupAccess::check([2])) {

                $this->extra =  [
                    'ticket_type' => [
                        'sql'            => '`ticket_type` = :ticket_type AND ',
                        'filters_values' => ForAll::valueFromKey('ticket', 'type')['TICKET_MESSAGE_TO_SITE_MASTER'],
                    ],
                ];
                #
            } else {
                $this->extra = [];
            }
        }

        return $this->extra;
    }

    private function __clone() {}
    public function __wakeup() {}
}
