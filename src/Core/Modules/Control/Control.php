<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Modules\Control;

defined('AIW_CMS') or die;

use Core\Content;
use Core\Modules\Control\Filters\Filters;
use Core\Modules\Control\Func;
use Core\Plugins\Msg;
use Core\Plugins\View\Style;
use Core\Plugins\View\Tpl;

class Control
{
    private $content = [];

    public function getContent(string $dirName = null)
    {
        /**
         * Get default values meta descriptions to page
         */
        if ($dirName === null) {
            $this->content = Content::getDefaultValue();
        } else {
            $this->content            = [];
            $this->content['msg']     = '';
            $this->content['content'] = '';
        }
        /**
         * Check access
         */
        if (Func::getI()->checkAccess($dirName) === true) { // If users access is true
            /**
             * Delete old filters values
             */
            Func::getI()->deleteOldFiltersNote();
            /**
             * Get actual page parameters
             */
            $params = Func::getI()->getParams();

            if ($dirName === null) {

                $this->content['meta']          = isset($params['meta'])          ? $params['meta']          : $this->content['meta'];
                $this->content['robots']        = isset($params['robots'])        ? $params['robots']        : $this->content['robots'];
                $this->content['canonical']     = isset($params['canonical'])     ? $params['canonical']     : $this->content['canonical'];
                $this->content['alternate']     = isset($params['alternate'])     ? $params['alternate']     : $this->content['alternate'];
                $this->content['sitemap_order'] = isset($params['sitemap_order']) ? $params['sitemap_order'] : $this->content['sitemap_order'];
                $this->content['description']   = isset($params['description'])   ? $params['description']   : $this->content['description'];
                $this->content['keywords']      = isset($params['keywords'])      ? $params['keywords']      : $this->content['keywords'];
            }
            /**
             * Get the number of content type records from the database according to the filter values
             */
            if (Func::getI()->countItemsId() > 0) { // If there are records in the database
                /**
                 * We connect scripts for filters,
                 * and display the shape of the filters
                 */
                if ($dirName === null) {
                    $this->filtersToContent();
                }
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
                if ($dirName === null) {

                    $this->filtersToContent();
                    /**
                     * Display a message that there are NO values according to all filters
                     */
                    // $this->content['msg'] = Msg::getMsg_('warning', 'MSG_NO_RESULT');                    
                    #
                }
                /**
                 * Display the list header
                 */
                $this->content['content'] .= Func::getI()->viewItemsList()['content'];
            }
            /**
             * If control content insert to other content type
             */
            if ($dirName === null) {
                /**
                 * If there is an indication of a specific template, print it,
                 * otherwise output template index
                 */
                $this->content['tpl'] = isset(Func::getI()->getParams()['tpl']) ? Func::getI()->getParams()['tpl'] : 'index';
                /**
                 * Specify correct title
                 */
                $this->content['title'] = Func::getI()->getParams()['title'];
            }
            #
        } else { // If the user does not have access rights

            if ($dirName === null) {
                $this->content = (new \App\Main\NoAccess\Cont)->getContent();
            } else {
                $this->content['content'] = '';
            }
        }
        #
        return $this->content;
    }

    private function filtersToContent()
    {
        $this->content['content'] .= Filters::getI()->viewFiltersForm();

        return $this->content;
    }
}
