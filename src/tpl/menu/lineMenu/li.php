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
<li><a class="<?= $v['li_class'] ?>" href="<?= $v['link'] ?>"><?= Trl::_($v['menu_title']) ?></a></li>
