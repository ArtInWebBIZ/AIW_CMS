<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Fields;

use Core\{Config, Trl, Languages};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Select\Other\Languages as Lang;

defined('AIW_CMS') or die;

class Item
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Item
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function curLang(string $value): mixed
    {
        return count(Languages::langList()) > 1 ? [
            'label'       => Trl::_('OV_LANG'),
            'name'        => 'cur_lang',
            'type'        => 'select',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => 2,
            'maxlength'   => 2,
            'check'       => Lang::getI()->clear(),
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? Lang::getI()->option($value) : Lang::getI()->option(),
            'info'        => '',
        ] : null;
    }

    public function introImg(string $value): array
    {
        return [
            'label'         => Trl::_('ITEM_INTRO_IMAGE'),
            'name'          => 'intro_img',
            'type'          => 'file',
            'clean'         => '',
            'disabled'      => false,
            'required'      => true,
            'max_file_size' => Config::getCfg('CFG_MAX_IMAGES_SIZE'),
            'allow_file_type' => ['jpg', 'jpeg', 'jpe', 'png'],
            'deny_file_type'  => ['exe', 'bat', 'ini', 'iso'],
            'class'         => 'uk-input',
            'placeholder'   => Trl::_('OV_FILE_SELECT'),
            'value'         => $value,
            'info'          => '',
        ];
    }

    public function heading(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_HEADING'),
            'name'        => 'heading',
            'type'        => 'text',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_HEADING_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_HEADING_LEN'),
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('ITEM_HEADING_EXAMPLE'),
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf('ITEM_HEADING_INFO', ...[
                Config::getCfg('CFG_MIN_HEADING_LEN'),
                Config::getCfg('CFG_MAX_HEADING_LEN'),
            ]),
        ];
    }

    public function keywords(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_KEYWORDS'),
            'name'        => 'keywords',
            'type'        => 'text',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_HEADING_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_HEADING_LEN'),
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . Trl::_('ITEM_KEYWORDS_EXAMPLE'),
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf('ITEM_KEYWORDS_INFO', ...[
                Config::getCfg('CFG_MIN_HEADING_LEN'),
                Config::getCfg('CFG_MAX_HEADING_LEN'),
            ]),
        ];
    }

    public function authorId(string $value): array
    {
        return [
            'label'       => Trl::_('OV_AUTHOR_ID'),
            'name'        => 'author_id',
            'type'        => 'text',
            'clean'       => 'unsInt',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => '',
        ];
    }

    public function itemId(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_ID'),
            'name'        => 'item_id',
            'type'        => 'text',
            'clean'       => 'unsInt',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => '',
        ];
    }

    public function description(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_DESCRIPTION'),
            'name'        => 'description',
            'type'        => 'text',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_HEADING_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_HEADING_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf('ITEM_DESCRIPTION_INFO', ...[
                Config::getCfg('CFG_MIN_HEADING_LEN'),
                Config::getCfg('CFG_MAX_HEADING_LEN'),
            ]),
        ];
    }

    public function introText(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_INTRO_TEXT'),
            'name'        => 'intro_text',
            'type'        => 'textarea',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTRO_TEXT_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTRO_TEXT_LEN'),
            'class'       => 'uk-textarea',
            'rows'        => Config::getCfg('CFG_TEXTAREA_ROWS'),
            'placeholder' => '',
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf('ITEM_INTRO_TEXT_INFO', ...[
                Config::getCfg('CFG_MIN_INTRO_TEXT_LEN'),
                Config::getCfg('CFG_MAX_INTRO_TEXT_LEN'),
            ]),
        ];
    }

    public function text(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_TEXT'),
            'name'        => 'text',
            'type'        => 'textarea',
            'clean'       => GroupAccess::check([5]) ? 'raw' : 'text',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_TEXT_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_TEXT_LEN'),
            'class'       => 'uk-textarea',
            'rows'        => Config::getCfg('CFG_TEXTAREA_ROWS'),
            'placeholder' => '',
            'value'       => $value,
            'info'        => Trl::_('OV_REQUIRED_FIELD') . Trl::sprintf('ITEM_TEXT_INFO', ...[
                Config::getCfg('CFG_MIN_TEXT_LEN'),
                Config::getCfg('CFG_MAX_TEXT_LEN'),
                'https://editorhtmlonline.com/'
            ]),
        ];
    }

    public function selfOrder(string $value): array
    {
        return [
            'label'       => Trl::_('ITEM_SELF_ORDER'),
            'name'        => 'self_order',
            'type'        => 'text',
            'clean'       => 'unsInt',
            'disabled'    => false,
            'required'    => false,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => Trl::_('OV_EXAMPLE') . '4500',
            'value'       => $value,
            'info'        => Trl::_('ITEM_SELF_ORDER_INFO'),
        ];
    }

    private function __clone() {}
    public function __wakeup() {}
}
