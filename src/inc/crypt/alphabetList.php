<?php

/**
 * @package    ArtInWebCMS.inc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

return array_merge(
    require PATH_INC . 'crypt' . DS . 'required' . DS . 'latinLowerCase.php',
    require PATH_INC . 'crypt' . DS . 'required' . DS . 'latinUpperCase.php',
    require PATH_INC . 'crypt' . DS . 'required' . DS . 'numbersList.php',
    require PATH_INC . 'crypt' . DS . 'required' . DS . 'symbols.php',
    require PATH_INC . 'crypt' . DS . 'required' . DS . 'cyrillic.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'ukrainian.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'russian.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'armenian.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'azerbaijani.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'basque.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'belarusian.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'bosnian.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'bulgarian.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'catalan.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'czech.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'danish.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'estonian.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'finnish.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'french.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'georgian.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'german.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'greek.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'kazakh.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'polish.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'portuguese.php',
    // require PATH_INC . 'crypt' . DS . 'unique' . DS . 'spanish.php',
);
