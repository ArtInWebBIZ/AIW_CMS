<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Test\Index\Req;

use Core\Auth;
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

defined('AIW_CMS') or die;

class Func
{
    private static $instance = null;
    private $checkAccess     = 'null';
    private $compareLangFile = 'null';
    private $checkUniqueSymbols = 'null';

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Return true if group this user is "Super User"
     * @return bool
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess === 'null') {

            $this->checkAccess = false;

            if (GroupAccess::check([5])) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Compare two languages files
     * @return string
     */
    public function compareLangFile(string $fileName, string $firstLang, string $secondLang): string
    {
        if ($this->compareLangFile == 'null') {

            if (file_exists(PATH_LANG . $firstLang . DS . $fileName . '.php')) {
                $firstLangArray  = require PATH_LANG . $firstLang . DS . $fileName . '.php';
            } else {
                die('Incorrect language file "' . $fileName . '" in language path "' . $firstLang . '".');
            }

            if (file_exists(PATH_LANG . $secondLang . DS . $fileName . '.php')) {
                $secondLangArray  = require PATH_LANG . $secondLang . DS . $fileName . '.php';
            } else {
                die('Incorrect language file "' . $fileName . '" in language path "' . $secondLang . '".');
            }

            $html = '';

            $html .= '<table class="uk-table uk-table-striped uk-table-middle">';

            foreach ($firstLangArray as $key => $value) {
                $secondLangValue = isset($secondLangArray[$key]) ? $secondLangArray[$key] : '';
                $html .= '
                <tr>
                    <td style="text-align: right;">' . $value . '</td>
                    <td style="text-align: center;">' . $key . '</td>
                    <td>' . $secondLangValue . '</td>
                </tr>';
                unset($secondLangArray[$key]);
            }
            unset($key, $value);

            if ($secondLangArray != []) {
                foreach ($secondLangArray as $key => $value) {
                    $html .= '
                    <tr>
                        <td></td>
                        <td style="text-align: center;">' . $key . '</td>
                        <td>' . $value . '</td>
                    </tr>';
                }
                unset($key, $value);
            }

            $html .= '</table>';

            $this->compareLangFile = $html;
        }

        return $this->compareLangFile;
    }
    /**
     * Return in string unique symbols
     * @return string
     */
    public function checkUniqueSymbols(array $languageAlphabet): string
    {
        if ($this->checkUniqueSymbols === 'null') {
            /**
             * Get all symbols array
             */
            $allSymbols = require PATH_INC . 'crypt' . DS . 'alphabetList.php';

            $html = '';

            foreach ($languageAlphabet as $key => $symbol) {
                if (array_search($symbol, $allSymbols, true) === false) {
                    $html .= '\'' . $symbol . '\', ';
                }
            }
            unset($key, $symbol);

            if ($html === '') {
                $html = 'No uniques symbol';
            } else {
                $html = trim($html, ", ");
            }

            $this->checkUniqueSymbols = $html;
        }

        return $this->checkUniqueSymbols;
    }
    #

    private function __clone() {}
    public function __wakeup() {}
}
