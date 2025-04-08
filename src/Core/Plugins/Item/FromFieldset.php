<?php

namespace Core\Plugins\Item;

defined('AIW_CMS') or die;

use Core\Trl;

class FromFieldset
{
    public static function toBody(array $values, string $pathToFieldset): string
    {
        $list = '';

        if (is_readable($pathToFieldset)) {

            $fieldsetList = array_flip(require $pathToFieldset);

            foreach ($values as $key => $value) {

                if (isset($fieldsetList[$value])) {
                    $list .= Trl::_($fieldsetList[$value]) . ', ';
                }
            }
            unset($key, $value);

            $list = trim($list, ", ");
        }

        return $list;
    }
}
