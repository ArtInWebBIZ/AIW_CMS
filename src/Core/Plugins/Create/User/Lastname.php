<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Create\User;

defined('AIW_CMS') or die;

class Lastname
{
    public function createdLastname(): void
    {
        $lang  = 'uk';
        $names = require PATH_INC . 'user' . DS . 'names' . DS . $lang . DS . 'man.php';

        $text = '<?php defined(\'DECLARE\') or die; return [';

        foreach ($names as $key => $value) {
            $text .= '\\\'' . str_replace("оі", "і", ($names[$key] . 'івна')) . '\\\', ';
        }

        $text .= '];';

        if (!is_readable(PATH_INC . 'user' . DS . 'names' . DS . $lang . DS . 'lastnameWoman.php')) {
            file_put_contents(PATH_INC . 'user' . DS . 'names' . DS . $lang . DS . 'lastnameWoman.php', $text);
            chmod(PATH_INC . 'user' . DS . 'names' . DS . $lang . DS . 'lastnameWoman.php', 0400);
        }
    }
}
