<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
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

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $checkAccess = 'null';
    /**
     * Return …
     * @return bool
     */
    public function checkAccess(): bool
    {
        if ($this->checkAccess == 'null') {

            $this->checkAccess = false;

            if (GroupAccess::check([5])) {
                $this->checkAccess = true;
            }
        }

        return $this->checkAccess;
    }
    #
    private $getFileDifference = [];
    /**
     * Return …
     * @return array
     */
    public function getFileDifference(string $langFile): array
    {
        if ($this->getFileDifference == []) {

            if (
                !is_readable(PATH_LANG . 'ru' . DS . $langFile . '.php')
            ) {
                debug('FILE ' . PATH_LANG . 'ru' . DS . $langFile . '.php' . ' - NOT FOND');
            } elseif (
                !is_readable(PATH_LANG . 'en' . DS . $langFile . '.php')
            ) {
                debug('FILE ' . PATH_LANG . 'en' . DS . $langFile . '.php' . ' - NOT FOND');
            } else {

                $ru = require PATH_LANG . 'ru' . DS . $langFile . '.php';
                $en = require PATH_LANG . 'en' . DS . $langFile . '.php';

                $notEn = [];

                foreach ($ru as $key => $value) {
                    if (!isset($en[$key])) {
                        $notEn[$key] = $value1;
                    }
                }

                debug('$notEn');
                debug($notEn);

                $notRu = [];

                foreach ($en as $key1 => $value1) {
                    if (!isset($ru[$key1])) {
                        $notRu[$key1] = $value1;
                    }
                }

                debug('$notRu');
                debug($notRu);
            }


            $this->getFileDifference = 'array_merge($notEn, [], $notRu)';
        }

        return $this->getFileDifference;
    }
    #
    private $newControllerToDb = 'null';
    /**
     * Return …
     * @return mixed
     */
    public function newControllerToDb(): mixed
    {
        if ($this->newControllerToDb == 'null') {

            $result = DB::getI()->getNeededField(
                [
                    'table_name'          => 'item',
                    'field_name'          => 'id`,`item_controller_id', // example 'id' or 'id`,`edited_count`,`brand_status'
                    'where'               => '`id` > :id',
                    'array'               => ['id' => 0],
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => 'ASC', // DESC
                    'offset'              => 0,
                    'limit'               => 0, // 0 - unlimited
                ]
            );

            if ($result != []) {

                foreach ($result as $key => $value) {

                    DB::getI()->update(
                        [
                            'table_name' => 'item_place',
                            'set'        => ParamsToSql::getSet(
                                $set = ['item_controller_id' => $result[$key]['item_controller_id']]
                            ),
                            'where'      => ParamsToSql::getSql(
                                $where = ['item_id' => $result[$key]['id']]
                            ),
                            'array'      => array_merge($set, $where),
                        ]
                    );

                    DB::getI()->update(
                        [
                            'table_name' => 'item_from_place',
                            'set'        => ParamsToSql::getSet(
                                $set = ['item_controller_id' => $result[$key]['item_controller_id']]
                            ),
                            'where'      => ParamsToSql::getSql(
                                $where = ['item_id' => $result[$key]['id']]
                            ),
                            'array'      => array_merge($set, $where),
                        ]
                    );
                }
            }

            $this->newControllerToDb = true;
        }

        return $this->newControllerToDb;
    }
    #
    private $newFilters = null;
    /**
     * Return …
     * @return mixed
     */
    public function newFilters(): mixed
    {
        if ($this->newFilters == null) {

            $this->newFilters = (array) DB::getI()->getColumn(
                [
                    'table_name'           => 'item_from_place',
                    'field_name'           => 'from_place',
                    'where'                => ParamsToSql::getSql(
                        $where = ['item_controller_id' => 2]
                    ),
                    'order_by_field_name'  => 'id',
                    'order_by_direction'   => 'ASC',
                    'offset'               => 0,
                    'limit'                => 0,
                    'array'                => $where,
                ]
            );
            // array_count_values
            $array = array_count_values($this->newFilters);
            ksort($array);
            $this->newFilters = $array;
        }

        return $this->newFilters;
    }

    private $compareLangFile = 'null';
    /**
     * Return …
     * @return string
     */
    public function compareLangFile(string $fileName, string $firstLang, string $secondLang): string
    {
        if ($this->compareLangFile == 'null') {

            $firstLangArray  = require PATH_LANG . $firstLang . DS . $fileName . '.php';
            $secondLangArray = require PATH_LANG . $secondLang . DS . $fileName . '.php';

            // debug(__FILE__ . ' - ' . __LINE__);
            // debug($firstLangArray);
            // die;

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
    #

    private function __clone() {}
    public function __wakeup() {}
}
