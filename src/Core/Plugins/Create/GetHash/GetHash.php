<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Create\GetHash;

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Crypt\CryptSalt;

class GetHash
{
    public static function getHash(string $secretStart, $text, string $secretEnd): string
    {
        return hash(Config::getCfg('hash_method'), $secretStart . '-' . $text . '-' . $secretEnd);
    }

    public static function getPassHash(string $pass): string
    {
        return hash(Config::getCfg('hash_method'), CryptSalt::getSalt()['salt_one'] . $pass . CryptSalt::getSalt()['salt_two']);
    }

    public static function getEmailHash(string $email): string
    {
        return hash(Config::getCfg('hash_method'), CryptSalt::getSalt()['salt_one'] . '@' . $email . '@' . CryptSalt::getSalt()['salt_two']);
    }

    public static function getDefHash(string $text): string
    {
        return hash(Config::getCfg('hash_method'), CryptSalt::getSalt()['salt_one'] . '-' . $text . '-' . CryptSalt::getSalt()['salt_two']);
    }
}
