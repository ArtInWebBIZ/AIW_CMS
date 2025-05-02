<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Fields;

defined('AIW_CMS') or die;

use Core\Trl;

class ForAll
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): ForAll
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function created(string $value): array
    {
        return [
            'label'       => Trl::_('OV_CREATED'),
            'name'        => 'created',
            'type'        => $value == '' ? 'date' : 'text',
            'clean'       => 'time',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => 19,
            'maxlength'   => 19,
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => '',
            'icon'        => 'calendar',
        ];
    }

    private function __clone() {}
    public function __wakeup() {}
}
