<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ConfigControl\Add;

defined('AIW_CMS') or die;

use App\ConfigControl\Add\Req\Func;
use Core\{Content, GV};
use Core\Plugins\{Msg, Ssl};

class Cont
{

    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['tpl']   = 'admin';
        $this->content['title'] = 'CONFIG_PARAMETER_ADD';

        if (Func::getI()->checkAccess() === true) {
            /**
             * If POST is empty
             */
            if (GV::post() === null) {
                /**
                 * View form add new config params
                 */
                $this->content['content'] .= Func::getI()->viewForm();
            }
            /**
             * If POST is NOT empty
             */
            else {
                /**
                 * Check form values
                 */
                if (!isset(Func::getI()->checkForm()['msg'])) {
                    /**
                     * Save new parameters in DB
                     */
                    if (Func::getI()->saveNewParameter() > 0) {
                        /**
                         * View message congratulate success add new parameters
                         */
                        $this->content['msg'] .= Msg::getMsg_('success', 'CONFIG_PARAMETER_ADD_SUCCESS');
                        /**
                         * User redirect to config control page
                         */
                        $this->content['redirect'] = Ssl::getLinkLang() . 'config-control/control/?id=' . Func::getI()->saveNewParameter();
                    }
                    /**
                     * If NOT success save new configs parameter
                     */
                    else {
                        /**
                         * View message ERROR add new parameters
                         */
                        $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR');
                        /**
                         * View form add new config params
                         */
                        $this->content['content'] .= Func::getI()->viewForm();
                    }
                }
                /**
                 * If incorrect form values
                 */
                else {
                    /**
                     * View errors message
                     */
                    $this->content['msg'] .= Func::getI()->checkForm()['msg'];
                    /**
                     * View form add new config params
                     */
                    $this->content['content'] .= Func::getI()->viewForm();
                }
            }
        } else {

            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
