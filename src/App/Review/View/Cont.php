<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Review\View;

defined('AIW_CMS') or die;

use App\Review\View\Req\Func;
use Core\{Content, Session, Trl};
use Core\Plugins\Check\{EditNote, IntPageAlias};
use Core\Plugins\Dll\ForAll;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = Trl::_('REVIEW_REVIEW') . ' #' . IntPageAlias::check();

        if (Func::getI()->checkAccess() === true) {

            if ((int) Func::getI()->getReview()['status'] === ForAll::contentStatus()['REVIEW_PUBLISHED']) {

                $this->content['canonical'] = ForAll::canonical(Func::getI()->getReview()['lang']);
                $this->content['alternate'] = ForAll::alternate(Func::getI()->getReview()['lang']);

                if (Func::getI()->getReview()['lang'] === Session::getLang()) {

                    $this->content['robots']        = ForAll::robots();
                    $this->content['sitemap_order'] = ForAll::sitemapOrder();
                    #
                }
            }
            /**
             * Delete edit note
             */
            EditNote::getI()->deleteNote();
            /**
             * View review
             */
            $this->content['content'] .= Func::getI()->viewReview();
            #
        } else {
            /**
             * View page 404
             */
            $this->content = (new \App\Main\Page404\Cont)->getContent();
        }

        return $this->content;
    }
}
