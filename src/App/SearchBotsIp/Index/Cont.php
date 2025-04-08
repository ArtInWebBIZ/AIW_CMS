<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\SearchBotsIp\Index;

defined('AIW_CMS') or die;

class Cont
{
    public function getContent()
    {
        return (new \Core\Modules\Control\Control)->getContent();
    }
}
