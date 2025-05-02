<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ContentType\Add;

defined('AIW_CMS') or die;

use App\ContentType\Add\Req\Func;
use Core\{Content, GV, Router, Session};
use Core\Plugins\Ssl;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = '#:TODO';

        if (Func::getI()->checkAccess() === true) {
            /**
             * Check global variable $_POST
             */
            if (GV::post() === null) {
                /**
                 * View add form
                 */
                $this->content['content'] .= Func::getI()->viewForm();
            }
            /**
             * If $_POST variable is NOT empty
             */
            else {
                /**
                 * Check form fields
                 */
                if (!isset(Func::getI()->checkForm()['msg'])) {
                    /**
                     * Save data to content type table
                     */
                    if (Func::getI()->saveToDb() > 0) {
                        /**
                         * Redirect to view content type page
                         */
                        $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . Func::getI()->saveToDb() . '.html';
                    }
                    #
                } else {
                    /**
                     * View error message
                     */
                    $this->content['msg'] .= Func::getI()->checkForm()['msg'];
                    /**
                     * Return to add form
                     */
                    $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/add/';
                    /**
                     * Update errors count in user`s session
                     */
                    Session::updSession(
                        [
                            'block_counter' => Session::getSession()['block_counter'] + 1
                        ]
                    );
                }
            }
            #
        } else {
            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }
}
