<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Signal\Ticket;

defined('AIW_CMS') or die;

use Core\Plugins\Signal\Ticket\Req\Func;
use Core\BaseUrl;

class Ticket
{
    public function getSignal()
    {
        if (Func::getI()->checkAccess() === true) {
            $color = Func::getI()->countTickets() > 0 ? 'warning' : 'success';
            return '<a href="' . BaseUrl::getLangToLink() . 'ticket/control-clear/" class="signal uk-flex uk-flex-center uk-flex-middle uk-alert-' . $color . '">' . Func::getI()->countTickets() . '</a>';
        } else {
            return '';
        }
    }
}
