<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

class EditForm
{
    /**
     * Check edit form
     * @param string $pathToFields
     * @return array // ['msg'] or array
     */
    public static function checkForm(string $pathToFields): array
    {
        return (new \Core\Plugins\Check\FormFields)->getCheckFields(
            require $pathToFields
        );
    }
    /**
     * Check edited fields
     * @param array $checkForm
     * @param array $itemRow
     * @return array
     */
    public static function checkEditedFields(array $checkForm, array $itemRow): array
    {
        $checkEditedFields = [];

        foreach ($checkForm as $key => $value) {

            if (isset($itemRow[$key])) {

                if (
                    $checkForm[$key] != $itemRow[$key]
                ) {
                    $checkEditedFields[$key] = $checkForm[$key];
                }
            } else {
                $checkEditedFields[$key] = $checkForm[$key];
            }
        }

        return $checkEditedFields;
    }
}
