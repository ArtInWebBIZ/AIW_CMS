<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Review\Edit;

defined('AIW_CMS') or die;

use App\Review\Edit\Req\Func;
use Core\{Content, GV};
use Core\Plugins\Check\{EditNote, IntPageAlias};
use Core\Plugins\{Msg, Ssl};

class Cont
{

    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'REVIEW_EDIT';

        if (Func::getI()->checkAccess() === true) {
            /**
             * Check edit note
             */
            if (EditNote::getI()->checkNote() === true) {
                /**
                 * Check data in $_POST
                 */
                if (GV::post() === null) {
                    /**
                     * View edit form
                     */
                    $this->content['content'] .=  Func::getI()->viewForm();
                    #
                }
                /**
                 * If $_POST is not empty
                 */
                else {
                    /**
                     * Require class Post
                     */
                    $this->content = (new \App\Review\Edit\Req\Post)->getContent();
                }
                #
            } else {
                /**
                 * View message about edit this review others user
                 */
                $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_EDIT_NOTE_ERROR');
                /**
                 * Redirect to reviews page
                 */
                $this->content['redirect'] = Ssl::getLinkLang() . 'review/' . IntPageAlias::check() . '.html';
            }
            #
        } else {
            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
