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

class CryptText
{
    private static $instance = null;
    private $getConfig       = null;
    private $getAlphabet     = null;

    private function __construct() {}

    public static function getI(): CryptText
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return crypt config file
     * @return array
     */
    private function getConfig(): array
    {
        if ($this->getConfig === null) {
            $this->getConfig = require PATH_PLUGINS . 'Crypt' . DS . 'inc' . DS . 'config.php';
        }

        return $this->getConfig;
    }
    /**
     * Get encrypted text
     * @param string $text
     * @return string
     */
    public function textEncrypt(string $text): string
    {
        $config  = $this->getConfig();
        $numbers = $this->getNumbers();
        /**
         * Convert $text to array
         */
        $textCount = mb_strlen($text);

        if ($textCount > $config['maxTextLen']) {
            return 'incorrect text len';
        } else {

            $toEncrypt = '';

            $text          = $textCount < 10 ? '0' . $textCount . $text : $textCount . $text;
            $textCount     = $textCount + 2;
            $randomTextLen = ($config['fullDecryptedLen'] - 2) - $textCount;
            $randomText    = Randomizer::fromArray($config['toRandomiser'], 0, $randomTextLen);
            $text          = $randomText . $text;
            $endTextLen    = ($config['fullDecryptedLen'] - 2) - mb_strlen($text);
            $endText       = Randomizer::fromArray($config['toRandomiser'], $endTextLen, $endTextLen);
            $text          = $text . $endText . (mb_strlen($randomText) < 10 ? '0' . mb_strlen($randomText) : mb_strlen($randomText));
            $text          = mb_str_split($text);

            foreach ($text as $key => $value) {
                if (array_search($value, $this->getAlphabet()) !== false) {
                    $toEncrypt .= array_search($value, $this->getAlphabet());
                } else {
                    $this->updAlphabet($value);
                    $toEncrypt .= array_search($value, $this->getAlphabet()) !== false ? array_search($value, $this->getAlphabet()) : array_search('*', $this->getAlphabet());
                }
            }
            unset($key, $value);

            $toEncrypt = mb_str_split($toEncrypt);

            $encrypt = [];

            foreach ($numbers as $key => $value) {
                $encrypt[$key] = $toEncrypt[$value];
            }
            unset($key, $value, $toEncrypt, $text);

            return implode('', $encrypt);
        }
    }
    /**
     * Get decrypted text
     * @param string $text
     * @return string
     */
    public function textDecrypt(string $text): string
    {
        $config = $this->getConfig();

        if (strlen($text) === $config['fullCryptLen']) {

            $numbers = array_flip($this->getNumbers());
            ksort($numbers);
            $alphabet = $this->getAlphabet();

            $text = str_split($text);
            $toDecrypt = [];

            foreach ($text as $key => $value) {
                $toDecrypt[$key] = $text[$numbers[$key]];
            }
            unset($key, $value);

            if (
                isset($alphabet[($toDecrypt[84] . $toDecrypt[85])]) &&
                isset($alphabet[($toDecrypt[86] . $toDecrypt[87])]) &&
                isset($alphabet[($toDecrypt[0] . $toDecrypt[1])]) &&
                isset($alphabet[($toDecrypt[2] . $toDecrypt[3])])
            ) {

                $betweenCount = $alphabet[($toDecrypt[84] . $toDecrypt[85])] . $alphabet[($toDecrypt[86] . $toDecrypt[87])];
                $betweenCount = $betweenCount[0] == '0' ? (int) $betweenCount[1] : (int) $betweenCount;

                if ($betweenCount > 0) {

                    foreach ($toDecrypt as $key => $value) {
                        if ($key < ($betweenCount * 2)) {
                            unset($toDecrypt[$key]);
                        }
                    }

                    $toDecrypt = implode('', $toDecrypt);
                    $toDecrypt = str_split($toDecrypt);
                }

                $count = $alphabet[($toDecrypt[0] . $toDecrypt[1])] . $alphabet[($toDecrypt[2] . $toDecrypt[3])];
                $count = $count[0] == '0' ? (int) $count[1] : (int) $count;

                $symbolCode = '';
                $decrypt    = '';

                for ($i = 0; $i < count($toDecrypt); $i++) {
                    if ($i < 4) {
                        continue;
                    }
                    if ($i > ($count * 2) + 4) {
                        break;
                    }
                    $symbolCode .= $toDecrypt[$i];
                    if (mb_strlen($symbolCode) == 2) {
                        $decrypt .= isset($alphabet[$symbolCode]) ? $alphabet[$symbolCode] : '*';
                        $symbolCode = '';
                    }
                }
                unset($i);

                return $decrypt;
                #
            } else {
                return 'incorrect file alphabet.php';
            }
            #
        } else {
            return 'incorrect text';
        }
    }
    /**
     * Get or create numbers.php file
     * @return array
     */
    private function getNumbers(): array
    {
        /**
         * Get numbers file.
         * If isset numbers file, get this file
         */
        if (is_readable(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'numbers.php')) {
            return require PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'numbers.php';
        } else {
            /**
             * Get crypt config file to array
             */
            $config = $this->getConfig();

            $numbers = [];

            for ($i = 0; $i < $config['fullCryptLen']; $i++) {

                $key = null;

                do {
                    $key = random_int(0, $config['fullCryptLen'] - 1);
                } while (isset($numbers[$key]));

                $numbers[$key] = $i;
            }
            unset($key);

            $numbers = array_flip($numbers);

            $text = "<?php\r\ndefined('AIW_CMS') or die;\r\nreturn [\r\n";

            foreach ($numbers as $key => $value) {
                $text .= "    $key => $value,\r\n";
            }
            unset($key, $value);

            $text .= "];";

            file_put_contents(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'numbers.php', $text);
            chmod(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'numbers.php', 0400);

            return require PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'numbers.php';
        }
    }
    /**
     * Return in array symbols code in key
     * @return array
     */
    private function getAlphabet(): array
    {
        if ($this->getAlphabet === null) {
            /**
             * Get alphabet file.
             * If isset alphabet file, get this file
             */
            if (is_readable(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php')) {
                $this->getAlphabet = require PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php';
            } else {
                /**
                 * Get crypt config file to array
                 */
                $config = $this->getConfig();

                $alphabet = [];

                foreach ($config['alphabet'] as $key => $value) {

                    do {
                        $code = $config['symbols'][random_int(0, count($config['symbols']) - 1)] .
                            $config['symbols'][random_int(0, count($config['symbols']) - 1)];
                    } while (isset($alphabet[$code]));

                    $alphabet[$code] = $value;
                }
                unset($key, $value);

                $text = "<?php\r\ndefined('AIW_CMS') or die;\r\nreturn [\r\n";

                foreach ($alphabet as $key => $value) {
                    if ($value == '\'') {
                        $text .= "    '$key' => '\\$value',\r\n";
                    } else {
                        $text .= "    '$key' => '$value',\r\n";
                    }
                }
                unset($key, $value);

                $text .= "];";

                file_put_contents(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php', $text);
                chmod(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php', 0400);

                $this->getAlphabet = require PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php';
            }
        }

        return $this->getAlphabet;
    }
    /**
     * Save new symbols to alphabet.php file
     * @param string $value
     * @return void
     */
    private function updAlphabet(string $value): void
    {
        /**
         * Get crypt config file to array
         */
        $config = $this->getConfig();

        $symbolKey = array_search($value, $config['alphabet']);

        if ($symbolKey !== false) {
            $fileArray = file(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php');
            $lastKey = array_key_last($fileArray);

            do {
                $code = $config['symbols'][random_int(0, count($config['symbols']) - 1)] . $config['symbols'][random_int(0, count($config['symbols']) - 1)];
            } while (isset($this->getAlphabet()[$code]));

            $fileArray[$lastKey] = "    '$code' => '$value',\r\n";
            $fileArray[$lastKey + 1] = "];";

            $text = '';

            foreach ($fileArray as $key => $value) {
                $text .= "$value";
            }
            unset($key, $value);

            chmod(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php', 0644);
            file_put_contents(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php', $text);
            chmod(PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php', 0400);

            $this->getAlphabet = require PATH_PLUGINS . 'Crypt' . DS . 'crypt' . DS . 'alphabet.php';
        }
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
