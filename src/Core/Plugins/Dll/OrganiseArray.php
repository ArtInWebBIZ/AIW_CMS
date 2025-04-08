<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Dll;

defined('AIW_CMS') or die;

class OrganiseArray
{
    public static function organise(array $array): array
    {
        asort($array);
        $array = implode(";", $array);
        return explode(";", $array);
    }
}
