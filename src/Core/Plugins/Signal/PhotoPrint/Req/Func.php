<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Signal\PhotoPrint\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\Model\DB;

class Func
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';
    /**
     * Check users access
     * @return boolean
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (
                Auth::getUserStatus() === 1 &&
                Auth::getUserGroup() >= 3
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }

    private $countPainedPhotoPrint = 'null';
    /**
     * Cont pained photo_prints ID
     * @return integer
     */
    public function countPainedPhotoPrint(): int
    {
        if ($this->countPainedPhotoPrint == 'null') {

            $this->countPainedPhotoPrint = (int) DB::getI()->countFields(
                [
                    'table_name' => 'photo_print',
                    'field_name' => 'id',
                    'where'      => '`status` = :status',
                    'array'      => ['status' => 1],
                ]
            );
        }

        return $this->countPainedPhotoPrint;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
