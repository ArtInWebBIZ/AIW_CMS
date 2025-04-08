<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Ssl;

?>
<div class="uk-section uk-section-large uk-flex uk-flex-middle vh100">
    <div class="uk-container uk-container-large">
        <a href="<?= Ssl::getLinkLang() . '?ref_code=' . $v['ref_code'] ?>">
            <div id="qr"></div>
        </a>
        <script>
            let text = '<?= Ssl::getLinkLang() . '?ref_code=' . $v['ref_code'] ?>';

            let typeNumber = 3;
            let errorLevel = 'L';
            let qrDiv = document.getElementById('qr');

            let qr1 = qrcode(typeNumber, errorLevel);

            qr1.addData(text);
            qr1.make();
            qrDiv.innerHTML += qr1.createImgTag(8, 10);
        </script>
    </div>
</div>
