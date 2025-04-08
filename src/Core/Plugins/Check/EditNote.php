<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\Auth;
use Core\Config;
use Core\Plugins\Model\DB;
use Core\Router;
use Core\Session;

// use Core\Plugins\Check\EditNote;

class EditNote
{
    private $checkNote       = 'null';
    private $iData           = [];
    private static $instance = null;
    private $checkNotesItem  = 'null';

    private function __construct()
    {
    }

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
    public function checkNote()
    {
        if ($this->checkNote == 'null') {

            /**
             * Удаляем старые записи
             */
            $this->delOldNotes();

            /**
             * Проверяем запись в таблице
             */
            if ( // Если запись существует, но создана не этим пользователем
                isset($this->checkNotesItem()['editor_id']) &&
                $this->checkNotesItem()['editor_id'] != Auth::getUserId()
            ) {

                $this->checkNote = false;
            } else {

                /**
                 * Если запись НЕ существует
                 */
                if ($this->checkNotesItem() === false) {
                    /**
                     * Создаём новую запись
                     */
                    $this->addNote();

                    $this->checkNote = true;
                }
                /**
                 * Если запись существует, и она создана ЭТИМ пользователем
                 */
                else {
                    /**
                     * Редактируем существующую запись
                     */
                    $this->updateNote();

                    $this->checkNote = true;
                }
            }
        }

        return $this->checkNote;
    }

    private function checkNotesItem()
    {
        if ($this->checkNotesItem == 'null') {

            $this->checkNotesItem = DB::getI()->getRow(
                [
                    'table_name' => 'edit_note',
                    'where'      => '
                        `content_type` = :content_type AND
                        `edited_id` = :edited_id
                    ',
                    'array'      => [
                        'content_type' => $this->iData()['content_type'],
                        'edited_id'    => $this->iData()['edited_id'],
                    ],
                ]
            );
        }

        return $this->checkNotesItem;
    }

    public function addNote()
    {
        return DB::getI()->add(
            [
                'table_name' => 'edit_note',
                'set'        => '
                    `token` = :token,
                    `content_type` = :content_type,
                    `edited_id` = :edited_id,
                    `editor_id` = :editor_id,
                    `enabled_to` = :enabled_to
                ',
                'array'      => [
                    'token'        => Session::getToken(),
                    'content_type' => $this->iData()['content_type'],
                    'edited_id'    => $this->iData()['edited_id'],
                    'editor_id'    => Auth::getUserId(),
                    'enabled_to'   => time() + Config::getCfg('CFG_NOTE_ENABLED_TO'),
                ],
            ]
        );
    }

    private function delOldNotes()
    {
        return DB::getI()->delete(
            [
                'table_name' => 'edit_note',
                'where'      => '`enabled_to` < :enabled_to',
                'array'      => ['enabled_to' => time()],
            ]
        );
    }

    private function updateNote()
    {
        return DB::getI()->update(
            [
                'table_name' => 'edit_note',
                'set'        => '
                    `token` = :token,
                    `enabled_to` = :enabled_to
                ',
                'where'      => '
                    `edited_id` = :edited_id
                ',
                'array'      => [
                    'token'      => Session::getToken(),
                    'enabled_to' => time() + Config::getCfg('CFG_NOTE_ENABLED_TO'),
                    'edited_id'  => $this->iData()['edited_id'],
                ],
            ]
        );
    }

    public function deleteNote()
    {
        return DB::getI()->delete(
            [
                'table_name' => 'edit_note',
                'where'      => '
                    `content_type` = :content_type AND
                    `edited_id` = :edited_id AND
                    `editor_id` = :editor_id
                ',
                'array'      => [
                    'content_type' => $this->iData()['content_type'],
                    'edited_id'    => $this->iData()['edited_id'],
                    'editor_id'    => Auth::getUserId(),
                ],
            ]
        );
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
