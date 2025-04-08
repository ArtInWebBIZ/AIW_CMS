<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item;

defined('AIW_CMS') or die;

use Core\{GV, Router, Session};
use Core\Plugins\Check\{CheckToken, EditNote, IntPageAlias, Item};
use Core\Plugins\Item\Edit\Func;
use Core\Plugins\{Msg, ParamsToSql, Ssl};
use Core\Plugins\Model\DB;
use Core\Plugins\Save\ToLog;

class Edit
{
    private $content = [];

    public function getContent()
    {
        if (Func::getI()->checkAccess() === true) {
            /**
             * Check edit note
             */
            if (EditNote::getI()->checkNote() === true) {
                /**
                 * Get default content values
                 */
                $this->content = Item::getI()->itemParams();
                /**
                 * Check variables in $_POST
                 */
                if (GV::post() === null) {
                    /**
                     * View edit form
                     */
                    $this->content['content'] .= Func::getI()->viewForm();
                    #
                } else {
                    /**
                     * Check token
                     */
                    if (CheckToken::checkToken() === true) {
                        /**
                         * Check form values
                         */
                        if (!isset(Item::getI()->checkForm()['msg'])) {
                            /**
                             * Check lang field in list edited fields
                             */
                            if (Item::getI()->checkForm()['cur_lang'] != Session::getLang()) {
                                /**
                                 * Redirect to item page
                                 */
                                $this->content['redirect'] = Ssl::getLink() . '/' . Item::getI()->checkForm()['cur_lang'] . '/' . Router::getRoute()['controller_url'] . '/edit/' . Item::getI()->checkItem()['id'] . '.html';
                                #
                            }
                            /**
                             * If item content in this language is false
                             */
                            elseif (Item::getI()->getItemCurLangId() === 0) {
                                /**
                                 * Save intro image in this content language
                                 */
                                if (
                                    isset(Item::getI()->checkForm()['intro_img']) &&
                                    !isset(Func::getI()->saveIntroImage()['msg'])
                                ) {
                                    $introImage = Func::getI()->saveIntroImage()['file_name'];
                                } else {
                                    $introImage = DB::getI()->getValue(
                                        [
                                            'table_name' => 'item_lang',
                                            'select'     => 'intro_img',
                                            'where'      => ParamsToSql::getSql(
                                                $where = [
                                                    'item_id'  => Item::getI()->checkItem()['id'],
                                                    'cur_lang' => Item::getI()->checkItem()['def_lang'],
                                                ]
                                            ),
                                            'array'      => $where,
                                        ]
                                    );
                                }
                                /**
                                 * Save item content in this language
                                 */
                                /**
                                 * Get all item_lang table fields
                                 */
                                $langsFields = Item::getI()->getAllItemFields()['lang'];
                                /**
                                 * Get value to fields
                                 */
                                $field = [];

                                foreach ($langsFields as $key => $fieldName) {
                                    if ($fieldName == 'intro_img') {
                                        $field[$fieldName] = $introImage;
                                    } else {
                                        $field[$fieldName] = Item::getI()->checkForm()[$fieldName];
                                    }
                                }
                                unset($key, $fieldName);
                                /**
                                 * Set values to item_id and intro_img fields
                                 */
                                $field['item_id']   = Item::getI()->checkItem()['id'];
                                /**
                                 * Save current languages content to database
                                 */
                                $newItemLangId = DB::getI()->add(
                                    [
                                        'table_name' => 'item_lang',
                                        'set'        => ParamsToSql::getSet($field),
                                        'array'      => $field,
                                    ]
                                );
                                /**
                                 * Redirect to correctly page
                                 */
                                if ($newItemLangId > 0) {
                                    /**
                                     * Redirect to view item page
                                     */
                                    $this->successEdit();
                                    #
                                } else {
                                    /**
                                     * Redirect to item edit page
                                     */
                                    $content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/edit/' . Item::getI()->checkItem()['id'] . '.html';
                                    /**
                                     * View message about error
                                     */
                                    $content['msg'] .= Msg::getMsg_('warning', 'MSG_SAVE_TO_DATABASE_ERROR');
                                    /**
                                     * Save error message to errors log
                                     */
                                    ToLog::blockCounter(__FILE__ . ' - ' . __LINE__);
                                    /**
                                     * Change block_counter in session
                                     */
                                    Session::updSession(
                                        [
                                            'block_counter' => Session::getSession()['block_counter'] + 1
                                        ]
                                    );
                                }
                            }
                            /**
                             * Check edited fields
                             */
                            elseif (Item::getI()->checkEditedFields() !== []) {
                                /**
                                 * If change intro image
                                 */
                                if (isset(Item::getI()->checkEditedFields()['intro_img'])) {
                                    /**
                                     * Save new image to server
                                     */
                                    if (!isset(Func::getI()->saveIntroImage()['msg'])) {
                                        /**
                                         * Save image name to edited fields
                                         */
                                        Func::getI()->changeEditedFields();
                                        #
                                    } else {
                                        /**
                                         * View error message
                                         */
                                        $this->content['msg'] .= Func::getI()->saveIntroImage()['msg'];
                                        /**
                                         * Save image name to edited fields
                                         */
                                        Func::getI()->changeEditedFields('unset');
                                    }
                                }
                                /**
                                 * Check items fields
                                 */
                                Func::getI()->checkEditedItemsFields();
                                /**
                                 * If Item::getI()->checkEditedFields() in not empty
                                 */
                                if (Item::getI()->checkEditedFields() != []) {
                                    /**
                                     * Save info about edit to item edit log
                                     */
                                    Func::getI()->saveToEditLog();
                                    /**
                                     * Check fieldset fields
                                     */
                                    Func::getI()->checkEditedFieldsetFields();
                                    /**
                                     * If Item::getI()->checkEditedFields() in not empty
                                     */
                                    if (Item::getI()->checkEditedFields() != []) {
                                        /**
                                         * Check fieldset fields
                                         */
                                        Func::getI()->checkEditedFiltersFields();
                                        /**
                                         * If Item::getI()->checkEditedFields() in not empty
                                         */
                                        if (Item::getI()->checkEditedFields() != []) {
                                            /**
                                             * Check edit item lang
                                             */
                                            if (!isset(Item::getI()->checkEditedFields()['lang'])) {
                                                /**
                                                 * Update languages item
                                                 */
                                                $this->updItemLang();
                                                #
                                            } else {
                                                /**
                                                 * Check needed langs item
                                                 */
                                                if (Func::getI()->checkItemLang() === false) {
                                                    /**
                                                     * Save new row to `item_lang` table
                                                     */
                                                    if (Func::getI()->newItemLang() === true) {
                                                        $this->successEdit();
                                                    }
                                                    #
                                                } else {
                                                    $this->updItemLang();
                                                }
                                            }
                                            #
                                        } else {
                                            $this->successEdit();
                                        }
                                        #
                                    } else {
                                        $this->successEdit();
                                    }
                                    #
                                } else {
                                    $this->successEdit();
                                }
                                #
                            } else {
                                /**
                                 * Delete edit note
                                 */
                                EditNote::getI()->deleteNote();
                                /**
                                 * Redirect to item page
                                 */
                                $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . Item::getI()->checkItem()['id'] . '.html';
                                #
                            }
                            #
                        } else {
                            /**
                             * View error message
                             */
                            $this->content['msg'] .= Item::getI()->checkForm()['msg'];
                            /**
                             * View edit form
                             */
                            $this->content['content'] .= Func::getI()->viewForm();
                            #
                        }
                    }
                }
                #
            } else {
                /**
                 * View message
                 */
                $this->content['msg'] .= Msg::getMsg_('warning', 'ITEM_BEING_EDITED');
                /**
                 * Redirect to item page
                 */
                $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . Item::getI()->checkItem()['id'] . '.html';
            }
            #
        } else {
            $this->content = (new \App\Main\NoAccess\Cont)->getContent();
        }

        return $this->content;
    }

    private function successEdit()
    {
        /**
         * Save new item edited date
         */
        Func::getI()->changeItemEditedDate();
        /**
         * Delete edit note
         */
        EditNote::getI()->deleteNote();
        /**
         * Redirect to item page
         */
        $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . Item::getI()->checkItem()['id'] . '.html';
    }

    private function updItemLang()
    {
        if (Func::getI()->updItemLang() === true) {
            /**
             * Update item edited date
             */
            Func::getI()->changeItemEditedDate();
            /**
             * Delete edit note
             */
            EditNote::getI()->deleteNote();
            /**
             * Redirect to item view page
             */
            $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . Item::getI()->checkItem()['id'] . '.html';
            #
        } else {
            /**
             * View error message
             */
            $this->content['msg'] .= Msg::getMsg_('warning', 'MSG_SAVE_CHANGE_ERROR');
            /**
             * View edit form
             */
            $this->content['content'] .= Func::getI()->viewForm();
            #
        }
    }
}
