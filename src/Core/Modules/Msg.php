<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Modules;

defined('AIW_CMS') or die;

use Core\{Clean, Trl};

class Msg
{
    private $msgType         = null;
    private $msgText         = null;
    private $msg             = null;
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Msg
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return alert messages to content page
     * @param string $msgType
     * @param string $msgText
     * @return string
     */
    public function getMsg(string $msgType, string $msgText): string
    {
        $this->msgType = Clean::str($msgType);

        if ($this->msgType == 'primary' || $this->msgType == 'success' || $this->msgType == 'warning' || $this->msgType == 'danger') {
            $this->msgType = $this->msgType;
        } else {
            $this->msgType = 'primary';
        }

        $this->msgText = $msgText;

        if (!empty($this->msgText)) {
            $this->msgText = $this->msgText;
        } else {
            $this->msgText = Trl::_('MSG_EMPTY');
        }

        if ($this->msgType == 'primary' || $this->msgType == 'success') {
            $h3 = Trl::_('MSG_MESSAGE');
        } elseif ($this->msgType == 'warning') {
            $h3 = Trl::_('MSG_WARNING');
        } elseif ($this->msgType == 'danger') {
            $h3 = Trl::_('MSG_DANGER');
        }

        $this->msg = '
        <div class="uk-alert-' . $this->msgType . '" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <h3>' . $h3 . '</h3>
            <p>' . $this->msgText . '</p>
        </div>';

        return $this->msg;
    }

    private function __clone() {}
    public function __wakeup() {}
}
