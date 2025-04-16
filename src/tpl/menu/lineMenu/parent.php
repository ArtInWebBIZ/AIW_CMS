<?php

/**
 * @package    ArtInWebCMS.tpl
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\Trl;

defined('AIW_CMS') or die;

?>
<li>
    <a class="<?= $v['active'] ?>" href><?= Trl::_($v['menu_title']) ?> <span uk-drop-parent-icon></span></a>
    <div class="uk-dropdown">
        <ul class="uk-nav uk-dropdown-nav">
            <?= $v['li'] ?>
        </ul>
    </div>
</li>
