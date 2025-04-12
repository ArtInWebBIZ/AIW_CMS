<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Blog\View\Req;

defined('AIW_CMS') or die;

use Core\{Auth, BaseUrl, Config, Trl};
use Core\Plugins\Check\{GroupAccess, Item};
use Core\Plugins\Dll\ForAll;
use Core\Plugins\Name\Blog\Status;
use Core\Plugins\View\Tpl;

class Func
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';

    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (
                $this->checkItem() !== false &&
                (
                    (int) $this->checkItem()['status'] === ForAll::contentStatus()['ITEM_PUBLISHED'] ||
                    (
                        Auth::getUserStatus() === 1 &&
                        (
                            (int) $this->checkItem()['author_id'] === Auth::getUserId() ||
                            GroupAccess::check([5])
                        )
                    )
                )
            ) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    #
    public function checkItem()
    {
        return Item::getI()->checkItem();
    }
    #
    private $itemView = 'null';
    /**
     * Return rendering item
     * @return string
     */
    public function itemView(): string
    {
        if ($this->itemView === 'null') {

            $this->itemView = Tpl::view(
                PATH_APP . 'Blog' . DS . 'View' . DS . 'inc' . DS . 'template.php',
                [
                    'id'          => $this->checkItem()['id'],
                    'heading'     => $this->checkItem()['heading'],
                    'schema_time' => date(Config::getCfg('CFG_SCHEMA_TIME_FORMAT'), $this->checkItem()['created']),
                    'created_date' => userDate(Config::getCfg('CFG_DATE_FORMAT'), $this->checkItem()['created']),
                    'created'    => $this->checkItem()['created'],
                    'intro_text' => $this->checkItem()['intro_text'],
                    'intro_img'  => $this->checkItem()['intro_img'],
                    'text'       => $this->checkItem()['text'],
                    'edit_link'  => $this->editLinkAccess() ?
                        ' / <a href="' . BaseUrl::getLangToLink() . 'blog/edit/' . $this->checkItem()['id'] . '.html" class="uk-text-primary">' . Trl::_('OV_EDIT') . '</a>' : '',
                    'status'    => $this->editLinkAccess() ? ' / ' . Status::getColor($this->checkItem()['status']) : '',
                    'publisher' => Tpl::view(PATH_TPL . 'view' . DS . 'publisher.php', ['itemprop' => 'publisher'])
                ]
            );
        }

        return $this->itemView;
    }

    private function editLinkAccess()
    {
        if (
            (int) $this->checkItem()['author_id'] === Auth::getUserId() || GroupAccess::check([3, 4, 5])
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
