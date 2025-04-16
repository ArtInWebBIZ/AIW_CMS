<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Dll;

defined('AIW_CMS') or die;

use Core\Plugins\Model\DB;
use Core\{Router, Session};
use Core\Plugins\ParamsToSql;

class FiltersNote
{
    private static $instance      = null;
    private $getFiltersNote       = null;
    private $getFiltersNoteValues = [];

    private function __construct() {}

    public static function getI(): FiltersNote
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Delete old filters note
     * @return boolean
     */
    public function deleteOldFiltersNote(): bool
    {
        return DB::getI()->delete(
            [
                'table_name' => 'filter_value_note',
                'where'      => '`enabled_to` < :enabled_to',
                'array'      => ['enabled_to' => time()],
            ]
        );
    }
    /**
     * Return array filters note or false
     * @return mixed // array or false
     */
    public function getFiltersNote(): array|false
    {
        if ($this->getFiltersNote === null) {

            $this->getFiltersNote = DB::getI()->getRow(
                [
                    'table_name' => 'filter_value_note',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'token'           => Session::getToken(),
                            'controller_name' => Router::getRoute()['controller_name'],
                            'action_name'     => Router::getRoute()['action_name'],
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->getFiltersNote;
    }
    /**
     * Return filters note values or NULL
     * @return array|null
     */
    public function getFiltersNoteValues(): array|null
    {
        if ($this->getFiltersNoteValues === []) {

            $this->getFiltersNoteValues = $this->getFiltersNote() !== false ?
                json_decode($this->getFiltersNote()['post_note'], true) : null;
        }

        return $this->getFiltersNoteValues;
    }

    private function __clone() {}
    public function __wakeup() {}
}
