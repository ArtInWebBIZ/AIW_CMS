<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Review\Add;

defined('AIW_CMS') or die;

use App\Review\Add\Req\Func;
use Core\{Content, GV};
use Core\Plugins\{Ssl, Msg};
use Core\Plugins\Check\GroupAccess;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'REVIEW_ADD';

        if (Func::getI()->checkAccess() === true) {
            /**
             * If empty global variable $_POST
             */
            if (GV::post() === null) {
                /**
                 * View form for adding new users review
                 */
                $this->content['content'] .= Func::getI()->viewForm();
                #
            } else {
                /**
                 * If is correct forms values
                 */
                if (!isset(Func::getI()->checkForm()['msg'])) {
                    /**
                     * Save users review to DB
                     */
                    if (Func::getI()->saveReview() > 0) {
                        /**
                         * Send email to moderator
                         */
                        Func::getI()->sendEmail();
                        /**
                         * View message about moderators confirm review
                         */
                        $this->content['msg'] .= Msg::getMsg_('success', 'REVIEW_SUCCESS_ADD_MSG');
                        /**
                         * Redirect to review page
                         */
                        $this->content['redirect'] = Ssl::getLinkLang() . 'review/' . Func::getI()->saveReview() . '.html';
                        #
                    } else {
                        /**
                         * View message about error adding new review
                         */
                        $this->content['msg'] .= Msg::getMsg_('warning', 'REVIEW_ERROR_ADD_MSG');
                        /**
                         * View form for adding new users review
                         */
                        $this->content['content'] .= Func::getI()->viewForm();
                    }
                }
            }
            #
        } else {
            /**
             * View no access message
             */
            $this->content['msg'] .= Msg::getMsg_('warning', 'REVIEW_NO_ACCESS_MSG');
            /**
             * Redirect to home page
             */
            $this->content['redirect'] = Ssl::getLinkLang() . 'review/my/';
            #
        }

        return $this->content;
    }
}
