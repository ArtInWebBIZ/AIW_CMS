<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\Contacts\Index\Req;

defined('AIW_CMS') or die;

use Core\{Auth, Config};
use Core\Plugins\Model\DB;
use Core\Plugins\View\Tpl;
use Core\Plugins\Check\GroupAccess;

class Func
{
    private static $instance     = null;
    private $checkAccess         = 'null';
    private $latestTicketsCreate = null;

    private function __construct() {}

    public static function getI(): Func
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Check users access
     * @return string
     */
    public function checkAccess(): string
    {
        if ($this->checkAccess === 'null') {

            $this->checkAccess = 'false';

            if (GroupAccess::check([5]) === false) {

                if (
                    Auth::getUserId() > 0 &&
                    Auth::getUserStatus() === 1
                ) {

                    if (time() > ($this->latestTicketsCreate() + Config::getCfg('CFG_NEW_TICKET_TIME'))) {
                        $this->checkAccess = 'true';
                    } else {
                        $this->checkAccess = 'msg';
                    }
                }
            }
        }

        return $this->checkAccess;
    }
    /**
     * Get date latest users ticket
     * @return integer
     */
    public function latestTicketsCreate(): int
    {
        if ($this->latestTicketsCreate === null) {

            $latestTicketsCreate = DB::getI()->getNeededField(
                [
                    'table_name'          => 'ticket',
                    'field_name'          => 'created',
                    'where'               => '`author_id` = :author_id',
                    'array'               => ['author_id' => Auth::getUserId()],
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => 'DESC',
                    'offset'              => 0,
                    'limit'               => 1,
                ]
            );

            $this->latestTicketsCreate = isset($latestTicketsCreate[0]['created']) ? (int) $latestTicketsCreate[0]['created'] : 0;

            unset($latestTicketsCreate);
        }

        return $this->latestTicketsCreate;
    }
    /**
     * Get add tickets form
     * @return string
     */
    public function getForm(): string
    {
        return Tpl::view(
            PATH_TPL . 'view' . DS . 'onlyForm.php',
            [
                'container_css'       => 'uk-container-small uk-background-default uk-padding-large', // container style
                'button_div_css'      => 'uk-margin-medium-top', // buttons div style
                'submit_button_style' => '', // submit button style
                'button_id'           => '',
                'h'                   => 'h2', // title weight
                'h_margin'            => 'uk-margin-large-bottom', // title style
                'include_after_form'  => '', // include after form

                'enctype'      => false, // false or true
                'title'        => null, // or null
                'url'          => 'ticket/new-ticket/',
                'cancel_url'   => 'hidden', // or '/controller/action/' or 'hidden'
                'v_image' => null, // or image path
                'fields'   => require PATH_APP . 'Contacts' . DS . 'Index' . DS . 'inc' . DS . 'fields.php',
                'button_label' => 'TICKET_ADD',
            ]
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
