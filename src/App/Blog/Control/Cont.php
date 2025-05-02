<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Blog\Control;

defined('AIW_CMS') or die;

class Cont
{
    public function getContent()
    {
        return (new \Core\Plugins\Item\Control)->getContent();
    }
}
