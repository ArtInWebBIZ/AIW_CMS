<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace PasteNameSpace; // VALUE IS EXAMPLE

use Core\Plugins\Check\Item;
use Core\Plugins\Lib\ForAll;

defined('AIW_CMS') or die;

class ClassName // VALUE IS EXAMPLE
{
    private $checkEditedFields = 'null';

    public function checkEditedFields()
    {
        if ($this->checkEditedFields == 'null') {

            $fieldsArr = require ForAll::contIncPath() . 'fields.php';

            foreach ($fieldsArr as $key1 => $value1) {
                if ($fieldsArr[$key1] !== null) {
                    $activeFields[$key1] = '';
                }
            }

            $fieldsArr = array_keys($activeFields);

            $this->checkEditedFields = [];

            foreach ($fieldsArr as $key => $value) {

                if (
                    isset($this->checkForm()[$value]) &&
                    $this->checkForm()[$value] != Item::getI()->checkItem()[$value]
                ) {
                    $this->checkEditedFields[$value] = $this->checkForm()[$value];
                }
            }
        }

        return $this->checkEditedFields;
    }
}
