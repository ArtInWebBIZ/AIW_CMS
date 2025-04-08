<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Signal\UserBalance;

defined('AIW_CMS') or die;

use Core\{Auth, BaseUrl, Config};
use Core\Plugins\Signal\UserBalance\Req\Func;

class UserBalance
{
    public function getSignal()
    {
        if (Func::getI()->checkAccess() === true) {
            $color = Auth::getUserBalance() > 0 ? 'success' : 'warning';
            return '<a href="' . BaseUrl::getLangToLink() . 'user/my-balance/" class="signal uk-flex uk-flex-center uk-flex-middle uk-alert-' . $color . '">' . Auth::getUserBalance() . '&#160;' . Config::getCfg('CFG_CURRENCY_SYMBOL') . '</a>';
        } else {
            return '';
        }
    }
}
