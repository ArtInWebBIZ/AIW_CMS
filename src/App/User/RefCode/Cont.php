<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\User\RefCode;

defined('AIW_CMS') or die;

use App\User\RefCode\Req\Func;
use Core\Content;

class Cont
{

    private $content = [];

    public function getContent()
    {
        $this->content          = Content::getDefaultValue();
        $this->content['title'] = 'QR-code';
        $this->content['tpl']   = 'toPrint';

        if (Func::getI()->checkAccess() === true) {

            $this->content['toTopScript'] .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.3/qrcode.min.js"></script>';

            $this->content['content'] .= Func::getI()->viewCode();
            #
        } else {
            $this->content = (new \App\Main\Page404\Cont)->getContent();
        }

        return $this->content;
    }
}
