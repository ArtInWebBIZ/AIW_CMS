<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Crypt;

use Core\Modules\Randomizer;

defined('AIW_CMS') or die;

class CryptSalt
{
    private static $salt = null;
    /**
     * Get in array website salt
     * @return array
     */
    public static function getSalt(): array
    {
        return self::setSalt();
    }
    /**
     * Get in array website salt or create salt file
     * @return array
     */
    private static function setSalt(): array
    {
        if (self::$salt === null) {

            if (!file_exists(PATH_PLUGINS  . 'Crypt' . DS . 'crypt' . DS . 'salt.php')) {

                $text = "<?php\r\n\r\ndefined('AIW_CMS') or die;\r\n\r\nreturn [\r\n";

                $text .= "    'salt_one' => '" . Randomizer::getRandomStr() . "',\r\n";
                $text .= "    'salt_two' => '" . Randomizer::getRandomStr() . "',\r\n";

                $text .= "];";

                file_put_contents(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'salt.php', $text);
                chmod(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'salt.php', 0400);
            }

            self::$salt = require PATH_PLUGINS  . 'Crypt' . DS . 'crypt' . DS . 'salt.php';
        }

        return self::$salt;
    }
}
