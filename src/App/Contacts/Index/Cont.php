<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Contacts\Index;

defined('AIW_CMS') or die;

use App\Contacts\Index\Req\Func;
use Core\{Auth, Config, Content, Trl};
use Core\Plugins\Lib\ForAll;
use Core\Plugins\View\Tpl;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content                  = Content::getDefaultValue();
        $this->content['title']         = 'CONTACTS_TITLE';

        $this->content['robots']        = ForAll::robots();
        $this->content['canonical']     = ForAll::canonical();
        $this->content['alternate']     = ForAll::alternate();
        $this->content['sitemap_order'] = ForAll::sitemapOrder();

        $contactTitle = '<h1 class="uk-text-center">' . Trl::_('CONTACTS_TITLE') . '</h1>';
        $section      = 'content-section uk-flex uk-flex-middle';
        $container    = 'uk-background-default';
        $overflow     = ' overflow-hidden uk-flex uk-flex-column uk-flex-center';

        if (Func::getI()->checkAccess() === 'msg') {
            $this->content['content'] .= Content::getContentStart($section, $container, $overflow);
            $this->content['content'] .= $contactTitle;
            $this->content['content'] .= '<h4 class="uk-text-center">' . Trl::sprintf(
                'CONTACTS_NEXT_TICKETS_TIME',
                ...[
                    userDate(Config::getCfg('CFG_DATE_TIME_FORMAT'), (Func::getI()->latestTicketsCreate() + Config::getCfg('CFG_NEW_TICKET_TIME'))),
                ]
            ) . '</h4>';
            $this->content['content'] .= Tpl::view(ForAll::contIncPath() . 'schema.php');
            $this->content['content'] .= Content::getContentEnd();
            #
        } elseif (Func::getI()->checkAccess() === 'true') {

            $this->content['content'] .= Content::getContentStart($section, $container, $overflow);
            $this->content['content'] .= $contactTitle;
            $this->content['content'] .= Tpl::view(ForAll::contIncPath() . 'schema.php');;
            $this->content['content'] .= Func::getI()->getForm();
            $this->content['content'] .= Content::getContentEnd();
            #
        } else { // Func::getI()->checkAccess() === 'false'

            $this->content['content'] .= Content::getContentStart($section, $container, $overflow);
            $this->content['content'] .= $contactTitle;
            $this->content['content'] .= Tpl::view(ForAll::contIncPath() . 'schema.php');
            $this->content['content'] .= Auth::getUserId() === 0 ? Tpl::view(ForAll::contIncPath() . 'msgToGuest.php') : '';
            $this->content['content'] .= Content::getContentEnd();
        }

        return $this->content;
    }
}
