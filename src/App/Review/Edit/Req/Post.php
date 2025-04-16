<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Review\Edit\Req;

defined('AIW_CMS') or die;

use Core\Content;
use App\Review\Edit\Req\Func;
use Core\Plugins\Check\IntPageAlias;
use Core\Plugins\{Msg, Ssl};

class Post
{

    private $content = [];

    public function getContent()
    {
        $this->content = Content::getDefaultValue();
        $this->content['title'] = 'REVIEW_EDIT';
        /**
         * Check for value
         */
        if (!isset(Func::getI()->checkForm()['msg'])) {
            /**
             * Check edited fields
             */
            if (Func::getI()->checkEditedFields() !== []) {
                /**
                 * If edited fields not empty
                 */
                if (!isset(Func::getI()->saveEditedFields()['msg'])) {
                    /**
                     * Redirect to review page
                     */
                    $this->content['redirect'] = Ssl::getLinkLang() . 'review/' . IntPageAlias::check() . '.html';
                    #
                } else {
                    /**
                     * View error save message
                     */
                    $this->content['msg'] .= Msg::getMsg_('warning', Func::getI()->saveEditedFields()['msg']);
                    /**
                     * View edit review form
                     */
                    $this->content['content'] .= Func::getI()->viewForm();
                }
            }
            #
        } else {
            /**
             * View message of error
             */
            $this->content['msg'] .= Func::getI()->checkForm()['msg'];
            /**
             * Redirect to review page
             */
            $this->content['redirect'] = Ssl::getLinkLang() . 'review/' . IntPageAlias::check() . '.html';
        }

        return $this->content;
    }
}
