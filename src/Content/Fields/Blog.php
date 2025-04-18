<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Content\Plugins\Fields;

use Core\{Trl};
use Core\Plugins\Select\Blog\Status;

defined('AIW_CMS') or die;

class Blog
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Blog
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
            'value'       => $value != '' ? Status::getI()->optionForm($value) : Status::getI()->optionForm(),
            'info'        => '',
        ];
    }

    private function __clone() {}
    public function __wakeup() {}
}
