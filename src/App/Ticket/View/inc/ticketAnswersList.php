<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

?>
<div class="uk-card uk-card-default uk-card-small uk-card-body">
    <table class="uk-table uk-table-small uk-table-striped uk-table-middle">
        <tr>
            <td class="uk-width-1-5"><span class="uk-text-small uk-text-muted"><?= $v['created'] ?></span></td>
            <td><strong><?= $v['author_id'] ?></strong></td>
        </tr>
        <tr>
            <td colspan="2"><?= $v['answer_text'] ?></td>
        </tr>
    </table>
</div>
