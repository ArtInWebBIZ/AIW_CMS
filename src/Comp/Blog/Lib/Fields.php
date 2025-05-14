<?php

/**
 * @package    ArtInWebCMS.Comp
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Comp\Blog\Lib;

use Core\Trl;
use Comp\Blog\Lib\Select\Status;

defined('AIW_CMS') or die;

class Fields
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Fields
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function status(string $value): array
    {
        return [
            'label'       => Trl::_('OV_STATUS'),
            'name'        => 'status',
            'type'        => 'select',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => 1,
            'maxlength'   => 1,
            'check'       => Status::getI()->clearForm(),
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? Status::getI()->optionForm((int) $value) : Status::getI()->optionForm(),
            'info'        => '',
        ];
    }

    private function __clone() {}
    public function __wakeup() {}
}
