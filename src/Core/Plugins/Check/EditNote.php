<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\{Auth, Config, Router, Session};
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

class EditNote
{
    private $checkNote       = 'null';
    private $iData           = [];
    private static $instance = null;
    private $checkNotesItem  = null;

    private function __construct() {}

    public static function getI(): EditNote
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function iData()
    {
        if ($this->iData == []) {
            $this->iData['content_type'] = str_replace("-", "_", Router::getRoute()['controller_url']);
            $this->iData['edited_id']    = Router::getPageAlias();
        }

        return $this->iData;
    }
    /**
     * Checked current edited notes
     * @return boolean // true or false
     */
    public function checkNote(): bool
    {
        if ($this->checkNote === 'null') {
            /**
             * We delete the old notes
             */
            $this->delOldNotes();
            /**
             * Check the entry in the table
             */
            if (
                /**
                 * If the record exists, but not created by this user
                 */
                isset($this->checkNotesItem()['editor_id']) &&
                $this->checkNotesItem()['editor_id'] != Auth::getUserId()
            ) {
                /**
                 * Set value to $this->checkNote
                 */
                $this->checkNote = false;
                #
            } else {
                /**
                 * If the recording does NOT exist
                 */
                if ($this->checkNotesItem() === false) {
                    /**
                     * We create a new record
                     */
                    $this->addNote();
                    /**
                     * Set value to $this->checkNote
                     */
                    $this->checkNote = true;
                    #
                }
                /**
                 * If the record exists and it is created by THIS user
                 */
                else {
                    /**
                     * We edit the existing entry
                     */
                    $this->updateNote();
                    /**
                     * Set value to $this->checkNote
                     */
                    $this->checkNote = true;
                }
            }
        }

        return $this->checkNote;
    }
    /**
     * Check in database note items
     * Return note items or false
     * @return array|boolean
     */
    private function checkNotesItem(): array|bool
    {
        if ($this->checkNotesItem === null) {

            $this->checkNotesItem = DB::getI()->getRow(
                [
                    'table_name' => 'edit_note',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'content_type' => $this->iData()['content_type'],
                            'edited_id'    => $this->iData()['edited_id'],
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->checkNotesItem;
    }
    /**
     * Add note edit this content to database
     * @return integer
     */
    public function addNote(): int
    {
        return DB::getI()->add(
            [
                'table_name' => 'edit_note',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'token'        => Session::getToken(),
                        'content_type' => $this->iData()['content_type'],
                        'edited_id'    => $this->iData()['edited_id'],
                        'editor_id'    => Auth::getUserId(),
                        'enabled_to'   => time() + Config::getCfg('CFG_NOTE_ENABLED_TO'),
                    ]
                ),
                'array'      => $set,
            ]
        );
    }
    /**
     * Delete old edit notes
     * @return boolean
     */
    private function delOldNotes(): bool
    {
        return DB::getI()->delete(
            [
                'table_name' => 'edit_note',
                'where'      => ParamsToSql::getSet(
                    $where = ['enabled_to' => time()]
                ),
                'array'      => $where,
            ]
        );
    }
    /**
     * Update edit note for this user and this content type
     * @return boolean
     */
    private function updateNote(): bool
    {
        return DB::getI()->update(
            [
                'table_name' => 'edit_note',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'token'      => Session::getToken(),
                        'enabled_to' => time() + Config::getCfg('CFG_NOTE_ENABLED_TO'),
                    ]
                ),
                'where'      => ParamsToSql::getSql(
                    $where = [
                        'content_type' => $this->iData()['content_type'],
                        'edited_id'    => $this->iData()['edited_id'],
                    ]
                ),
                'array'      => array_merge($set, $where),
            ]
        );
    }
    /**
     * Delete edit note after successfully edited this content
     * @return boolean
     */
    public function deleteNote(): bool
    {
        return DB::getI()->delete(
            [
                'table_name' => 'edit_note',
                'where'      => ParamsToSql::getSql(
                    $where = [
                        'content_type' => $this->iData()['content_type'],
                        'edited_id'    => $this->iData()['edited_id'],
                        'editor_id'    => Auth::getUserId(),
                    ]
                ),
                'array'      => $where,
            ]
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
