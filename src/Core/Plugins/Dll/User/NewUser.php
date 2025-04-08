<?php

namespace Core\Plugins\Dll\User;

defined('AIW_CMS') or die;

use Core\Config;
use Core\Plugins\Dll\User;
use Core\Plugins\Model\DB;
use Core\Trl;
use Core\Plugins\Ssl;
use Core\Plugins\ParamsToSql;
use Core\Session;

class NewUser
{
    private static $instance = null;
    private $create = 'null';

    private function __construct() {}

    public static function getI(): NewUser
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Full process new users register
     * Return users ID or false
     * Obligatory params:
     * $params['email']
     * @return integer|boolean|array // new user ID or false
     */
    public function create(array $params = []): int|bool
    {
        if ($this->create == 'null') {

            $this->create = false;

            if ($params != []) {
                /**
                 * Add new user to 'user' table in database
                 */
                $userId = (int) User::getI()->addUser($params);
                /**
                 * If new user successfully save to table
                 */
                if ($userId > 0) {
                    /**
                     * Save data to activation table
                     */
                    $return = User::getI()->saveToActivationTable($userId);
                    /**
                     * If data successfully save to user activation table
                     */
                    if ($return === true) {
                        /**
                         * Send to user email about needed activation
                         */
                        $to      = $params['email'];
                        $subject = Trl::_('EMAIL_CONFIRM');
                        $message = Trl::sprintf(
                            'EMAIL_CREATE_NEW_USER',
                            ...[
                                Ssl::getLinkLang() . 'user/login/',
                                Ssl::getLinkLang() . 'user/login/',
                                User::getI()->generateUserPass(),
                                Ssl::getLinkLang() . 'contacts/',
                            ]
                        );

                        $return = (new \Core\Modules\Email)->sendEmail($to, $subject, $message);
                        /**
                         * If successfully send email to new user
                         */
                        if ($return === true) {
                            /**
                             * Update user`s session
                             */
                            Session::updSession(
                                [
                                    'tmp_status'   => 0,
                                    'save_session' => 1,
                                    'enabled_to'   => time() + Config::getCfg('CFG_MAX_SESSION_TIME'),
                                ]
                            );

                            $this->create = $userId;
                        }
                        /**
                         * Else delete new user in 'user' table
                         */
                        else {
                            $this->deleteNewUser($userId);
                        }
                    }
                    /**
                     * Else delete new user from 'user' table
                     */
                    else {
                        $this->deleteNewUser($userId);
                    }
                }
            }
        }

        return $this->create;
    }
    #
    private function deleteNewUser(int $id): bool
    {
        return DB::getI()->delete(
            [
                'table_name' => 'user',
                'where'      => ParamsToSql::getSql(
                    $where = [
                        'id' => $id,
                    ]
                ),
                'array'      => $where,
            ]
        );
    }
    #


    private function __clone() {}
    public function __wakeup() {}
}
