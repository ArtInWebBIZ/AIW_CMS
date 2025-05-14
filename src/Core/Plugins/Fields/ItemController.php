<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Fields;

use Core\{Config, Trl};
use Core\Plugins\Select\Other\NoYes;

defined('AIW_CMS') or die;

class ItemController
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): ItemController
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Get field 'controller_url'
     * @param string $value
     * @return array
     */
    public function controllerUrl(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_CONTROLLER_URL'),
            'name'        => 'controller_url',
            'type'        => 'text',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_ITEM_CONTROLLER_URL_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_ITEM_CONTROLLER_URL_LEN'),
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . 'controller-name',
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf('ITEM_CONTROLLER_URL_INFO', ...[
                Config::getCfg('CFG_MIN_ITEM_CONTROLLER_URL_LEN'),
                Config::getCfg('CFG_MAX_ITEM_CONTROLLER_URL_LEN'),
            ]),
        ];
    }
    /**
     * Get field 'filters_table'
     * @param string $value
     * @return array
     */
    public function filtersTable(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_FILTERS_TABLE'),
            'name'        => 'filters_table',
            'type'        => 'select',
            'clean'       => 'unsInt',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'check'       => NoYes::clear(),
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? NoYes::option((int) $value) : NoYes::option(),
            'info'        => '',
        ];
    }
}
