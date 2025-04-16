<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Trl;

?>
<div id="messages_cookies" class="uk-position-bottom uk-position-fixed uk-background-muted">
    <div class="messages_cookies-wrp uk-flex uk-flex-middle uk-flex-column">
        <div class="uk-padding uk-padding-remove-left uk-padding-remove-right">
            <span class="uk-text-small"><?= Trl::_('MSG_COOKIE_MSG') ?></span>
        </div>
        <div class="uk-margin-bottom uk-text-center">
            <button class="uk-button uk-button-primary uk-button-small messages_cookies-close">OK</button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="/js/cookie_mc.js"></script>
