<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Signal\PhotoPrint;

defined('AIW_CMS') or die;

use Core\Plugins\Signal\PhotoPrint\Req\Func;
use Core\BaseUrl;

class PhotoPrint
{
    public function getSignal()
    {
        if (Func::getI()->checkAccess() === true) {
            $color = Func::getI()->countPainedPhotoPrint() > 0 ? 'danger' : 'success';
            return '<a href="' . BaseUrl::getLangToLink() . 'photo-print/control-clear/" class="signal uk-flex uk-flex-center uk-flex-middle uk-alert-' . $color . '">' . Func::getI()->countPainedPhotoPrint() . '</a>';
        } else {
            return '';
        }
    }
}
