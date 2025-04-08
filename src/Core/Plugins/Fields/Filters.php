<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Fields;

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Select\Order\OrderOption;
use Core\Trl;

class Filters
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getI(): Filters
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function order(string $value): array
    {
        return [
            'label'       => Trl::_('ORDER_BY'),
            'name'        => 'order_by',
            'type'        => 'select',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => false,
            'check'       => OrderOption::getI()->clear(),
            'minlength'   => '',
            'maxlength'   => '',
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? OrderOption::getI()->option($value) : OrderOption::getI()->option(),
            'info'        => '',
        ];
    }

    public function createdFrom(string $value): array
    {
        return [
            'label'       => Trl::_('OV_CREATED_FROM'),
            'name'        => 'created_from',
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

    public function createdTo(string $value): array
    {
        return [
            'label'       => Trl::_('OV_CREATED_TO'),
            'name'        => 'created_to',
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

    public function editedFrom(string $value): array
    {
        return [
            'label'       => Trl::_('OV_EDITED_FROM'),
            'name'        => 'edited_from',
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

    public function editedTo(string $value): array
    {
        return [
            'label'       => Trl::_('OV_EDITED_TO'),
            'name'        => 'edited_to',
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

    public function editedId(string $value): array
    {
        return [
            'label'       => Trl::_('LABEL_EDITED_ID'),
            'name'        => 'edited_id',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => '',
            'icon'        => '',
        ];
    }

    public function editorId(string $value): array
    {
        return [
            'label'       => Trl::_('LABEL_EDITOR_ID'),
            'name'        => 'editor_id',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => '',
            'icon'        => '',
        ];
    }

    public function authorId(string $value): array
    {
        return [
            'label'       => Trl::_('LABEL_AUTHOR_ID'),
            'name'        => 'author_id',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => '',
            'icon'        => '',
        ];
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
