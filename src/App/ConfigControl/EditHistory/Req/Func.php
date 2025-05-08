<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\ConfigControl\EditHistory\Req;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Plugins\{ParamsToSql, Check\GroupAccess, Model\DB};

class Func
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = null;

    public function checkAccess(): bool
    {
        if ($this->checkAccess === null) {

            $this->checkAccess = false;

            if (GroupAccess::check([5])) {
                $this->checkAccess =  true;
            }
        }

        return $this->checkAccess;
    }
    /**
     * Get extra params
     * @return array
     */
    public function extra(): array
    {
        if (Auth::getUserGroup() !== 5) {
            /**
             * Select accepted fields
             */
            $fields = DB::getI()->getNeededField(
                [
                    'table_name'          => 'config_control',
                    'field_name'          => 'params_name',
                    'where'               => '`group_access` = :group_access',
                    'array'               => ['group_access' => Auth::getUserGroup()],
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => 'ASC',
                    'offset'              => 0,
                    'limit'               => 0,
                ]
            );

            if ($fields != []) {

                foreach ($fields as $key => $value) {
                    $fieldsName[$key] = $fields[$key]['params_name'];
                }

                $fieldsName = ParamsToSql::getInSql($fieldsName);

                return [
                    'edited_params' => [
                        'sql'            => '`edited_params`' . $fieldsName['in'] . ' AND ',
                        'filters_values' => $fieldsName['array'],
                    ],
                ];
                #
            } else {
                return [];
            }
            #
        } else {
            return [];
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
