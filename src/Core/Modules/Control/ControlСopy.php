<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules\Control;

defined('AIW_CMS') or die;

use Core\Content;
use Core\Modules\Control\Func;

class ControlСopy
{
    private $content = [];

    public function getContent()
    {
        /**
         * Get default values meta descriptions to page
         */
        $this->content = Content::getDefaultValue();
        /**
         * Check access
         */
        if (Func::getI()->checkAccess() === true) { // If users access is true
            /**
             * Delete old filters values
             */
            Func::getI()->deleteOldFiltersNote();
            /**
             * Get actual page parameters
             */
            $params = Func::getI()->getParams();

            $this->content['meta']          = isset($params['meta'])          ? $params['meta']          : $this->content['meta'];
            $this->content['robots']        = isset($params['robots'])        ? $params['robots']        : $this->content['robots'];
            $this->content['canonical']     = isset($params['canonical'])     ? $params['canonical']     : $this->content['canonical'];
            $this->content['alternate']     = isset($params['alternate'])     ? $params['alternate']     : $this->content['alternate'];
            $this->content['sitemap_order'] = isset($params['sitemap_order']) ? $params['sitemap_order'] : $this->content['sitemap_order'];
            $this->content['description']   = isset($params['description'])   ? $params['description']   : $this->content['description'];
            $this->content['keywords']      = isset($params['keywords'])      ? $params['keywords']      : $this->content['keywords'];
            /**
             * Get the number of content type records from the database according to the filter values
             */
            if (Func::getI()->countItemsId() > 0) { // Если записи  в БД есть
                /**
                 * We connect scripts for filters,
                 * and display the shape of the filters
                 */
                $this->filtersToContent();
                /**
                 * Retrieving all records
                 */
                if (isset(Func::getI()->viewItemsList()['msg'])) {
                    /**
                     * If there are errors in the form, we display the corresponding message.
                     */
                    $this->content['msg'] .= Func::getI()->viewItemsList()['msg'];
                    #
                } else {
                    /**
                     * If not errors in filters
                     */
                    $this->content['content'] .= Func::getI()->viewItemsList()['content'];
                }
                #
            } else { // If there are no records matching all filters
                /**
                 * Including scripts for filters,
                 * and display the filter form
                 */
                $this->filtersToContent();
                /**
                 * Display a message that there are NO values according to all filters
                 */
                // $this->content['msg'] = Msg::getMsg_('warning', 'MSG_NO_RESULT');
                /**
                 * Display the list header
                 */
                $this->content['content'] .= Func::getI()->viewItemsList()['content'];
            }
            /**
             * If there is an indication of a specific template, print it,
             * otherwise output template index
             */
            $this->content['tpl'] = isset(Func::getI()->getParams()['tpl']) ? Func::getI()->getParams()['tpl'] : 'index';
            /**
             * Specify correct title
             */
            $this->content['title'] = Func::getI()->getParams()['title'];
            #
        } else { // If the user does not have access rights
            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }
        #
        return $this->content;
    }

    private function filtersToContent()
    {
        $this->content['content'] .= Func::getI()->viewFiltersForm();

        return $this->content;
    }
}
