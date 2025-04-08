<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\{Auth, Config, Clean, Trl, GV};
use Core\Plugins\Ssl;

class ErrorHandler
{
    private $content         = [];
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getI(): ErrorHandler
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * We store processed errors here,
     * and return, depending on the code, the name of the error
     *
     * @param $error
     * @return string
     */
    public static function getErrorName($error)
    {
        $errors = [
            E_ERROR             => 'ERROR',
            E_PARSE             => 'PARSE',
            E_WARNING           => 'WARNING',
            E_CORE_ERROR        => 'CORE_ERROR',
            E_NOTICE            => 'NOTICE',
            E_COMPILE_ERROR     => 'COMPILE_ERROR',
            E_CORE_WARNING      => 'CORE_WARNING',
            E_USER_ERROR        => 'USER_ERROR',
            E_COMPILE_WARNING   => 'COMPILE_WARNING',
            E_USER_NOTICE       => 'USER_NOTICE',
            E_USER_WARNING      => 'USER_WARNING',
            E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
            E_STRICT            => 'STRICT',
            E_USER_DEPRECATED   => 'USER_DEPRECATED',
            E_DEPRECATED        => 'DEPRECATED',
        ];

        if (array_key_exists($error, $errors)) {
            return $errors[$error] . " [$error]";
        }

        return $error;
    }
    /**
     * Let's register this method as our own:
     * 1. error handler (both normal and fatal)
     * 2. catcher of exceptions thrown outside the try{} catch(){} block
     */
    public function register()
    {
        // telling php to track all possible errors
        ini_set('display_errors', 'on');
        error_reporting(E_ALL | E_STRICT);

        // register our error handler
        set_error_handler([$this, 'errorHandler']);

        // register our thrown exception handler
        set_exception_handler([$this, 'exceptionHandler']);

        // register our function, which is executed before the script ends
        // needed to catch fatal errors. In practice it is rarely used.
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }
    /**
     * A method that will now handle errors instead of PHP.
     * Please note that the method returns true,
     * if it returns false or null, then error handling will be transferred to the built-in handler
     *
     * @param $errno
     * @param $errstr
     * @param $file
     * @param $line
     * @return bool
     */
    public function errorHandler($errno, $errstr, $file, $line)
    {
        // here you can record the error in the log if necessary

        // display error information in the browser
        $this->showError($errno, $errstr, $file, $line);

        // return true so that error handling control is NOT transferred to the built-in handler
        return true;
    }
    /**
     * The method that will handle exceptions is
     * called outside the try/catch block
     *
     * @param \Exception $e
     */
    public function exceptionHandler(\Throwable $e)
    {
        // display information about the exception in the browser
        $this->showError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    }
    /**
     * A method that detects the presence of a fatal error and processes it.
     */
    public function fatalErrorHandler()
    {
        // if we find a fatal error in the buffer,
        if ($error = error_get_last() and $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            echo ob_end_clean(); // reset buffer, terminate buffer

            // then display it in the browser
            $this->showError($error['type'], $error['message'], $error['file'], $error['line'], 500);
        }

        // otherwise, we do nothing and leave the script to the discretion of the built-in handler.
    }

    public function showError($errno, $errorstr, $file, $line, $status = 500)
    {
        if (!isset($this->content['error'])) {
            $this->content['error'] = '';
        }

        if (
            Config::getCfg('CFG_DEBUG') === true ||
            Auth::getUserGroup() == 5
        ) {

            $this->content['error'] .= '
            <table class="uk-table uk-table-small uk-table-striped uk-table-middle uk-background-default">
                <tr>
                    <td class="uk-text-right">Link:</td>
                    <td><strong>' . Ssl::getLink() . '/' . ltrim(trim(Clean::url(substr(GV::server()['REQUEST_URI'], 1))), '/') . '</strong></td>
                </tr>
                <tr>
                    <td class="uk-text-right">Error number:</td>
                    <td><strong>' . $errno . '</strong></td>
                </tr>
                <tr>
                    <td class="uk-text-right">Error:</td>
                    <td><strong>' . $errorstr . '</strong></td>
                </tr>
                <tr>
                    <td class="uk-text-right">File:</td>
                    <td><strong>' . $file . '</strong></td>
                </tr>
                <tr>
                    <td class="uk-text-right">Line:</td>
                    <td><strong>' . $line . '</strong></td>
                </tr>
            </table>
            <hr>';

            return $this->content['error'];
            #
        } else {
            $this->sendEmail($errno, $errorstr, $file, $line);
            return $this->content['error'] = Trl::_('ERROR_MESSAGE_TO_BROWSER');
        }
    }

    private function sendEmail($errno, $errorstr, $file, $line)
    {
        return (new \Core\Modules\Email)->sendEmail(
            Config::getCfg('CFG_TECH_SUPPORT_USER_EMAIL'),
            Trl::_('ERROR_EMAIL_SUBJECT'),
            '<table class="uk-table uk-table-small uk-table-striped uk-table-middle uk-background-default">
                <tr>
                    <td class="uk-text-right">Link:</td>
                    <td><strong>' . Ssl::getLink() . '/' . ltrim(trim(Clean::url(substr(GV::server()['REQUEST_URI'], 1))), '/') . '</strong></td>
                </tr>
                <tr>
                    <td class="uk-text-right">' . Trl::_('ERROR_NUMBER') . '</td>
                    <td><strong>' . $errno . '</strong></td>
                </tr>
                <tr>
                    <td class="uk-text-right">' . Trl::_('ERROR_NAME') . '</td>
                    <td><strong>' . $errorstr . '</strong></td>
                </tr>
                <tr>
                    <td class="uk-text-right">' . Trl::_('ERROR_FILE') . '</td>
                    <td><strong>' . $file . '</strong></td>
                </tr>
                <tr>
                    <td class="uk-text-right">' . Trl::_('ERROR_STRING') . '</td>
                    <td><strong>' . $line . '</strong></td>
                </tr>
            </table>
            <hr>'
        );
    }
    #
    public function getErrors()
    {
        return $this->content;
    }
    #
    private function __clone()
    {
    }
    #
    public function __wakeup()
    {
    }
}
