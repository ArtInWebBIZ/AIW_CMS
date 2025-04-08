<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Other;

defined('AIW_CMS') or die;

use Core\Trl;

class Languages
{
    private static $instance     = null;
    private static $allLanguages = null;

    private function __construct() {}

    public static function getI(): Languages
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllLanguages(): array
    {
        if (self::$allLanguages === null) {

            $allLang = require PATH_INC . 'languages.php';

            foreach ($allLang as $key => $value) {
                $languages[$allLang[$key][2]] = $value[0];
            }

            self::$allLanguages = $languages;
        }

        return self::$allLanguages;
    }

    public function clear()
    {
        return self::getAllLanguages();
    }

    public function option($editedField = 'null')
    {
        $clear = $this->clear();

        $selected = $editedField == 'null' ? ' selected="selected"' : '';

        $languagesOptionHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($clear as $key => $value) {
            $selected = $value === $editedField ? ' selected="selected"' : '';
            $languagesOptionHtml .= '
            <option value="' . $value . '"' . $selected . '>' . $key . '</option>';
        }

        return $languagesOptionHtml;
    }

    private function __clone() {}
    public function __wakeup() {}
}
