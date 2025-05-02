<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

class FilterFields
{
    /**
     * Return checked filters values from form
     * or error message (key ['msg]) in case of error
     * @return array
     */
    public function checkFilterFields(array $fieldsArray): array
    {
        /**
         * Getting an array of data from the filter form,
         * and remove empty array keys
         */
        $filterFields = [];

        foreach ((new \Core\Plugins\Check\FormFields)->getCheckFields($fieldsArray) as $key => $value) {
            if ($value != '') {
                $filterFields[$key] = $value;
            }
        }
        unset($key, $value);

        return isset($filterFields['msg']) ? [] : $filterFields;
    }
}
