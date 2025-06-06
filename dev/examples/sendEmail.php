<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\{Auth, Trl};

function sendEmail()
{
    return (new \Core\Modules\Email)->sendEmail(
        Auth::getUserEmail(),
        Trl::_('EMAIL_CONFIRM_PAY_TO_CARD'),
        Trl::_('EMAIL_CONFIRM_PAY_TO_CARD_TEXT')
    );
}
