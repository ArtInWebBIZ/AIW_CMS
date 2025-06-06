<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Tpl;

defined('AIW_CMS') or die;

?>
<?= '' // (new \Core\Modules\Control\Control)->getContent('Review')['content'] 
?>
<?= Tpl::view(ForAll::contIncPath() . 'contacts.php') ?>
<?= '' // (new Core\Plugins\Item\ControlToCont)->getContent('Blog') 
?>
