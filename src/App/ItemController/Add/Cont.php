<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\ItemController\Add;

defined('AIW_CMS') or die;

use App\ItemController\Add\Req\Func;
use Core\{Content, GV};
use Core\Plugins\{Msg, Ssl};

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['tpl']   = 'admin';
        $this->content['title'] = 'ITEM_CONTROLLER_URL_ADD';

        if (Func::getI()->checkAccess() === true) {
            /**
             * Check global variable $_POST
             */
            if (GV::post() === null) {
                /**
                 * View add form new controllers URL
                 */
                $this->content['content'] .= Func::getI()->viewForm();
                #
            } else {
                /**
                 * Check values in form
                 */
                if (!isset(Func::getI()->checkForm()['msg'])) {
                    /**
                     * Check correct new controller url
                     */
                    if (Func::getI()->checkCorrectControllerUrl() === false) {
                        /**
                         * Save new controllers url to DB
                         */
                        if (Func::getI()->saveControllerUrl() > 0) {
                            /**
                             * Redirect to controllers url list
                             */
                            $this->content['redirect'] = Ssl::getLinkLang() . 'item-controller/';
                        }
                        #
                    } else {
                        /**
                         * View message
                         */
                        $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_INVALID_CONTROLLER_URL');
                        /**
                         * View add form new controllers URL
                         */
                        $this->content['content'] .= Func::getI()->viewForm();
                        #
                    }
                } else {
                    /**
                     * View errors message
                     */
                    $this->content['msg'] .= Func::getI()->checkForm()['msg'];
                    /**
                     * View add form
                     */
                    $this->content['content'] .= Func::getI()->viewForm();
                }
            }
            #
        } else {
            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
