<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Fields;

defined('AIW_CMS') or die;

use Core\{Config, Trl};
use Core\Plugins\Select\Review\{Rating, Status};

class Review
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Review
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function id(string $value): array
    {
        return [
            'label'       => Trl::_('LABEL_ID'),
            'name'        => 'id',
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
        ];
    }

    public function authorId(string $value): array
    {
        return [
            'label'       => Trl::_('OV_AUTHOR_ID'),
            'name'        => 'author_id',
            'type'        => 'text',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_INTEGER_LEN'),
            'class'       => 'uk-input',
            'placeholder' => '',
            'value'       => $value,
            'info'        => '',
        ];
    }

    public function text(string $value): array
    {
        return [
            'label'       => Trl::_('REVIEW_TEXT'),
            'name'        => 'text',
            'type'        => 'textarea',
            'clean'       => 'text',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_TICKET_ANSWER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MAX_TICKET_ANSWER_LEN'),
            'class'       => 'uk-textarea',
            'rows'        => Config::getCfg('CFG_TEXTAREA_ROWS'),
            'placeholder' => '',
            'value'       => $value,
            'info'        => Trl::_('OV_OBLIGATORY_FIELD') . Trl::sprintf('ITEM_TEXT_INFO', ...[
                Config::getCfg('CFG_MIN_TICKET_ANSWER_LEN'),
                Config::getCfg('CFG_MAX_TICKET_ANSWER_LEN'),
                'https://editorhtmlonline.com/'
            ]),
        ];
    }

    public function rating(string $value): array
    {
        return [
            'label'       => Trl::_('REVIEW_RATING'),
            'name'        => 'rating',
            'type'        => 'select',
            'clean'       => 'int',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'check'       => Rating::getI()->clear(),
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? Rating::getI()->option($value) : Rating::getI()->option(),
            'info'        => '',
        ];
    }

    public function status(string $value): array
    {
        return [
            'label'       => Trl::_('OV_STATUS'),
            'name'        => 'status',
            'type'        => 'select',
            'clean'       => 'str',
            'disabled'    => false,
            'required'    => true,
            'minlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'maxlength'   => Config::getCfg('CFG_MIN_INTEGER_LEN'),
            'check'       => Status::getI()->clear(),
            'class'       => 'uk-select',
            'placeholder' => '',
            'value'       => $value != '' ? Status::getI()->option($value) : Status::getI()->option(),
            'info'        => '',
        ];
    }

    private function __clone() {}
    public function __wakeup() {}
}
