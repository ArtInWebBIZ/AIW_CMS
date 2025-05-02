<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ContentType\ControlClear;

defined('AIW_CMS') or die;

class Cont
{
    public function getContent()
    {
        return (new \Core\Modules\ControlClear\ControlClear)->getContent();
    }
}
