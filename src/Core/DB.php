<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use PDO;
use PDOException;

class DB
{
    private static $dsn  = '';
    private static $user = '';
    private static $pass = '';

    /**
     * PDO object.
     */
    public static $dbh = null;
    /**
     * Statement Handle.
     */
    public static $sth = null;
    /**
     * Executed SQL query.
     */
    public static $query = '';
    private static $dbConnect = null;
    /**
     * Default value
     */
    private static $returnQuery = '';
    private static $returnParam = [];
    private static $returnValue = null;

    private static $sqlNum = 0;

    /**
     * Return database connect params
     * @return array
     */
    private static function dbConnect(): array
    {
        if (self::$dbConnect == null) {

            if (file_exists(PATH_BASE . 'db.php')) {
                self::$dbConnect = require_once PATH_BASE . 'db.php';
            } else {
                self::$dbConnect = [];
            }
        }

        return self::$dbConnect;
    }
    #
    /**
     * Connecting to the database
     */
    public static function getDbh()
    {
        if (!self::$dbh) {

            if (self::dbConnect() !== []) {

                $dbConnect = self::dbConnect();

                self::$dsn  = 'mysql:dbname=' . $dbConnect['db_name'] . ';host=' . $dbConnect['host'];
                self::$user = $dbConnect['username'];
                self::$pass = $dbConnect['password'];

                try {
                    self::$dbh = new PDO(
                        self::$dsn,
                        self::$user,
                        self::$pass,
                        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"]
                    );
                    self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                } catch (PDOException $e) {
                    die('ERROR!!! No database connection :( !!!');
                }
                #
            } else {
                die('ERROR!!! No database config connection :( !!!');
            }
        }

        return self::$dbh;
    }
    /**
     * Adding to the table, if successful, will return the inserted ID, otherwise 0.
     */
    public static function add(string $query, array $param = [])
    {
        if (
            self::$returnQuery != $query ||
            self::$returnParam != $param
        ) {
            self::$returnQuery = $query;
            self::$returnParam = $param;

            self::viewSgl($query, $param);

            self::$sth = self::getDbh()->prepare($query);
            self::$returnValue = (self::$sth->execute((array) $param)) ? self::getDbh()->lastInsertId() : 0;
        }

        return self::$returnValue;
    }
    /**
     * Executing the request.
     * @return boolean // true or false
     */
    public static function set(string $query, array $param = [])
    {
        if (
            self::$returnQuery != $query ||
            self::$returnParam != $param
        ) {
            self::$returnQuery = $query;
            self::$returnParam = $param;

            self::viewSgl($query, $param);

            self::$sth = self::getDbh()->prepare($query);
            self::$returnValue = self::$sth->execute((array) $param);
        }

        return self::$returnValue;
    }
    /**
     * Getting a row from a table.
     * @return mixed // array or false
     */
    public static function getRow(string $query, array $param = [])
    {
        if (
            self::$returnQuery != $query ||
            self::$returnParam != $param
        ) {
            self::$returnQuery = $query;
            self::$returnParam = $param;

            self::viewSgl($query, $param);

            self::$sth = self::getDbh()->prepare($query);
            self::$sth->execute((array) $param);
            self::$returnValue = self::$sth->fetch(PDO::FETCH_ASSOC);
        }

        return self::$returnValue;
    }
    /**
     * Getting a row from a table.
     * @return mixed // array or []
     */
    public static function getFromManyTable(string $query, array $param = []): array
    {
        if (
            self::$returnQuery != $query ||
            self::$returnParam != $param
        ) {
            self::$returnQuery = $query;
            self::$returnParam = $param;

            self::viewSgl($query, $param);

            self::$sth = self::getDbh()->prepare($query);
            self::$sth->execute((array) $param);
            self::$returnValue = self::$sth->fetchAll(PDO::FETCH_UNIQUE);
        }

        return self::$returnValue;
    }
    /**
     * Retrieving all rows from a table.
     * @return array // array or []
     */
    public static function getAll(string $query, array $param = [])
    {
        if (
            self::$returnQuery != $query ||
            self::$returnParam != $param
        ) {
            self::$returnQuery = $query;
            self::$returnParam = $param;

            self::viewSgl($query, $param);

            self::$sth = self::getDbh()->prepare($query);
            self::$sth->execute((array) $param);
            self::$returnValue = self::$sth->fetchAll(PDO::FETCH_ASSOC);
        }

        return self::$returnValue;
    }
    /**
     * Getting the value.
     * @return mixed // value or null
     */
    public static function getValue(string $query, array $param = [], $default = null)
    {
        if (
            self::$returnQuery != $query ||
            self::$returnParam != $param
        ) {
            self::$returnQuery = $query;
            self::$returnParam = $param;

            self::viewSgl($query, $param);

            self::$sth = self::getDbh()->prepare($query);
            self::$sth->execute((array) $param);
            $result = self::$sth->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                $result = array_shift($result);
            }
            self::$returnValue = empty($result) ? $default : $result;
        }

        return self::$returnValue;
    }
    /**
     * Getting a table column.
     * @return array // array or []
     */
    public static function getColumn(string $query, array $param = [])
    {
        if (
            self::$returnQuery != $query ||
            self::$returnParam != $param
        ) {
            self::$returnQuery = $query;
            self::$returnParam = $param;

            self::viewSgl($query, $param);

            self::$sth = self::getDbh()->prepare($query);
            self::$sth->execute((array) $param);
            self::$returnValue = self::$sth->fetchAll(PDO::FETCH_COLUMN);
        }

        return self::$returnValue;
    }

    private static function viewSgl(string $query, array $param)
    {
        if (
            isset(self::dbConnect()['view_sql']) &&
            self::dbConnect()['view_sql'] === 1
        ) {
            echo '<div style="background-color: #ffffff">';
            debug(self::$sqlNum = self::$sqlNum + 1);
            debug($query);
            debug($param);
            echo '========================<br>';
            echo '</div>';
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
