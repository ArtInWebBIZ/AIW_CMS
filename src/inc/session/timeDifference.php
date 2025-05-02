<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

?>
<div id="time_difference" class="uk-invisible">
    <script>
        let d = new Date();
        let loc = Date.UTC(d.getFullYear(), d.getMonth(), d.getDate(), d.getHours(), d.getMinutes(), d.getSeconds());
        let time_difference = ((loc / 1000) - <?= time() ?>);

        document.cookie = "time_difference=" + time_difference + "; path=/; max-age=1209600;";

        let div = document.getElementById("time_difference");
        div.parentNode.removeChild(div);
    </script>
</div>
