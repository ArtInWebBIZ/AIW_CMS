<?php

namespace Core\Plugins\Fields;

defined('AIW_CMS') or die;

use Core\{Config, Trl};
use Core\Plugins\Select\Excursion\{Transport, Type};

class Excursion
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Excursion
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function type($value)
    {
        return [
            'label'       => Trl::_('EXCURSION_TYPE'),
            'name'        => 'type',
            'type'        => 'select',
            'clean'       => 'unsInt',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => 1,
            'maxlength'   => 1,
            'check'       => Type::getI()->clear(),
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? Type::getI()->option($value) : Type::getI()->option(),
            'info'        => Trl::_('OV_OBLIGATORY_FIELD'),
        ];
    }

    public function place($value)
    {
        return [
            'label'       => Trl::_('EXCURSION_PLACE'),
            'name'        => 'place',
            'type'        => 'fieldset_checkbox',
            'disabled'    => false,
            'required'    => true,
            'fields_path' => PATH_INC . 'excursion' . DS . 'place.php',
            'value'       => $value,
            'info'        => '',
        ];
    }

    public function fromPlace($value)
    {
        return [
            'label'       => Trl::_('EXCURSION_FROM_PLACE'),
            'name'        => 'from_place',
            'type'        => 'fieldset_checkbox',
            'disabled'    => false,
            'required'    => true,
            'fields_path' => PATH_INC . 'excursion' . DS . 'place.php',
            'value'       => $value,
            'info'        => '',
        ];
    }

    public function transport($value)
    {
        return [
            'label'       => Trl::_('EXCURSION_TRANSPORT'),
            'name'        => 'transport',
            'type'        => 'select',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => 1,
            'maxlength'   => 1,
            'check'       => Transport::getI()->clear(),
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? Transport::getI()->option($value) : Transport::getI()->option(),
            'info'        => Trl::_('OV_OBLIGATORY_FIELD'),
        ];
    }

    public function length($value)
    {
        return [
            'label'       => Trl::_('EXCURSION_LENGTH'),
            'name'        => 'length',
            'type'        => 'text',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => 1,
            'maxlength'   => 5,
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('EXCURSION_LENGTH_INFO'),
        ];
    }

    public function price_3($value)
    {
        return [
            'label'       => Trl::_('EXCURSION_PRICE_3'),
            'name'        => 'price_3',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('EXCURSION_PRICE_3_INFO'),
        ];
    }

    public function price_6($value)
    {
        return [
            'label'       => Trl::_('EXCURSION_PRICE_6'),
            'name'        => 'price_6',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('EXCURSION_PRICE_6_INFO'),
        ];
    }

    public function price_group($value)
    {
        return [
            'label'       => Trl::_('EXCURSION_GROUP'),
            'name'        => 'price_group',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::_('EXCURSION_GROUP_INFO'),
        ];
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
