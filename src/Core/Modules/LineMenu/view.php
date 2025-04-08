<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Create\Menu\LineMenu;

?>

<?= LineMenu::getI()->createMenu(
    [
        'menu_access'    => true,
        'menu_title'     => 'OV_HOME',
        'controller_url' => '',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ]
); ?>
<?= LineMenu::getI()->createMenu(
    [
        'menu_access'    => true,
        'menu_title'     => 'DOC_ABOUT_US',
        'controller_url' => 'doc',
        'action_url'     => '',
        'page_alias'     => 'about-us',
        #
        'menu_list'   => [],
    ]
); ?>
<?= LineMenu::getI()->createMenu(
    [
        'menu_access'    => true,
        'menu_title'     => 'EXCURSION_EXCURSIONS',
        'controller_url' => 'excursion',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ]
); ?>
<?= LineMenu::getI()->createMenu(
    [
        'menu_access'    => true,
        'menu_title'     => 'SERVICE_SERVICE',
        'controller_url' => 'service',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ]
); ?>
<?= LineMenu::getI()->createMenu(
    [
        'menu_access'    => true,
        'menu_title'     => 'REVIEW_REVIEWS',
        'controller_url' => 'review',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ]
); ?>
<?= LineMenu::getI()->createMenu(
    [
        'menu_access'    => true,
        'menu_title'     => 'BLOG_BLOG',
        'controller_url' => 'blog',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ]
); ?>
<?= LineMenu::getI()->createMenu(
    [
        'menu_access'    => true,
        'menu_title'     => 'OV_CONTACTS',
        'controller_url' => 'contacts',
        'action_url'     => '',
        'page_alias'     => '',
        #
        'menu_list'   => [],
    ]
); ?>
