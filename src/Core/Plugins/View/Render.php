<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\View;

defined('AIW_CMS') or die;

use Core\{App, Auth, BaseUrl, Config, GV, Router, Session};
use Core\Plugins\Check\GroupAccess;
use Core\Plugins\Check\TimeDifference;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;

class Render
{
    private static $instance   = null;
    private $getPageParams     = null;
    private $getPageCashTime = null;

    private function __construct() {}

    public static function getI(): Render
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function render(): void
    {
        $this->deleteOldCash();

        $render = '';

        if (
            Config::getCfg('CFG_DEBUG') === false &&
            Config::getCfg('CFG_CONTENT_CASH') === true
        ) {

            if (
                is_array($this->getPageParams()) &&
                Auth::getUserId() === 0 &&
                GV::post() === null &&
                GV::get() === null &&
                file_exists(PATH_CASH . $this->getPageParams()['id'] . '.php')
            ) {
                /**
                 * View page from cash
                 */
                $render = Tpl::view(
                    PATH_CASH . $this->getPageParams()['id'] . '.php',
                    [
                        'token'            => Session::getToken(),
                        'messages_cookies' => $this->messagesCookies(),
                        'time_difference'  => $this->getTimeDifference(),
                    ]
                );

                if (App::content()['redirect'] === '') {

                    if (Session::getSearchBotsIp() === 1) {
                        ViewLog::saveToLog('view_index_log', (int) $this->getPageParams()['id']);
                    } else {
                        ViewLog::saveToLog('view_log', (int) $this->getPageParams()['id']);
                    }
                }
                #
            } else {
                /**
                 * Get template file path
                 */
                $tplPath = PATH_TPL . App::content()['tpl'] . '.php';
                /**
                 * Check template file
                 */
                if (file_exists($tplPath)) {
                    /**
                     * If isset template file
                     */
                    $render = Tpl::view($tplPath);

                    if (
                        $this->getPageCashTime() > 0 &&
                        Auth::getUserId() === 0 &&
                        isset($this->getPageParams()['sitemap_order']) &&
                        (int) $this->getPageParams()['sitemap_order'] > 0
                    ) {

                        if (
                            $this->saveToCashLog() > 0
                        ) {

                            $cash = str_replace(Session::getToken(), '<?= $v[\'token\'] ?>', $render);
                            $cash = str_replace('<!-- messages_cookies -->', '<?= $v[\'messages_cookies\'] ?>', $cash);
                            $cash = str_replace('<!-- time_difference -->', '<?= $v[\'time_difference\'] ?>', $cash);

                            $fp = fopen(PATH_CASH . $this->getPageParams()['id'] . '.php', 'w+');
                            fwrite($fp, $cash);
                            fclose($fp);
                        }
                    }

                    $render = str_replace('<!-- messages_cookies -->', $this->messagesCookies(), $render);
                    $render = str_replace('<!-- time_difference -->', $this->getTimeDifference(), $render);
                    #
                } else {
                    debug('Incorrect template ' . App::content()['tpl']);
                }
            }

            echo $render;
            #
        } else {
            /**
             * Get template file path
             */
            $tplPath = PATH_TPL . App::content()['tpl'] . '.php';
            /**
             * Check template file
             */
            if (file_exists($tplPath)) {
                /**
                 * If template file successfully checked
                 */
                include_once PATH_TPL . App::content()['tpl'] . '.php';
                #
            } else {
                debug('Incorrect template ' . App::content()['tpl']);
            }
        }
    }
    /**
     * Return current page params or false
     * @return array|bool
     */
    private function getPageParams(): array|bool
    {
        if ($this->getPageParams === null) {

            $this->getPageParams = DB::getI()->getRow(
                [
                    'table_name' => 'list_page',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'lang' => Session::getLang(),
                            'url'  => BaseUrl::getOnlyUrl()
                        ]
                    ),
                    'array'      => $where,
                ]
            );
        }

        return $this->getPageParams;
    }
    /**
     * Return cash time or zero (0)
     * @return integer
     */
    private function getPageCashTime(): int
    {
        if ($this->getPageCashTime === null) {

            $pageCashParams = require PATH_INC . 'for-all' . DS . 'sitemap.php';

            $controllerName = Router::getRoute()['controller_name'];
            $actionName     = Router::getRoute()['action_name'];

            $pageCashParams = isset($pageCashParams[$controllerName][$actionName]['cash_time']) ?
                $pageCashParams[$controllerName][$actionName]['cash_time'] : 0;

            if ($pageCashParams === true) {
                $this->getPageCashTime = Config::getCfg('CFG_CONTENT_CASH_TIME');
            } else {
                $this->getPageCashTime = $pageCashParams;
            }
        }

        return $this->getPageCashTime;
    }
    #
    #
    private function deleteOldCash(): bool
    {
        /**
         * Get all old cashed pages ID
         */
        $oldPagesCashId = DB::getI()->getNeededField(
            [
                'table_name'          => 'cash_log',
                'field_name'          => 'list_page_id',
                'where'               => '`enabled_to` < :enabled_to',
                'array'               => ['enabled_to' => time()],
                'order_by_field_name' => 'list_page_id',
                'order_by_direction'  => 'ASC',
                'offset'              => 0,
                'limit'               => 0,
            ]
        );
        /**
         * If list old cashed pages ID not empty
         */
        if (
            is_array($oldPagesCashId) &&
            count($oldPagesCashId) > 0
        ) {

            $pagesId = [];

            foreach ($oldPagesCashId as $key => $value) {
                /**
                 * Delete cash file
                 */
                if (
                    file_exists(PATH_CASH . $oldPagesCashId[$key]['list_page_id'] . '.php')
                ) {
                    unlink(PATH_CASH . $oldPagesCashId[$key]['list_page_id'] . '.php');
                }
                /**
                 * Save to array old cashed pages ID
                 */
                $pagesId[] = $oldPagesCashId[$key]['list_page_id'];
            }
            unset($key, $value, $oldPagesCashId);
            /**
             * Prepare SQL
             */
            $in = ParamsToSql::getInSql($pagesId);
            /**
             * Delete from cash_log old cashed notes
             */
            DB::getI()->delete(
                [
                    'table_name' => 'cash_log',
                    'where'      => '`list_page_id`' . $in['in'],
                    'array'      => $in['array'],
                ]
            );
            unset($pagesId, $in);
        }

        return true;
    }
    #
    private function saveToCashLog(): int
    {
        return DB::getI()->add(
            [
                'table_name' => 'cash_log',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'list_page_id' => $this->getPageParams()['id'],
                        'enabled_to'   => time() + $this->getPageCashTime(),
                    ]
                ),
                'array'      => $set,
            ]
        );
    }

    private function messagesCookies(): string
    {
        if (
            (
                !isset(GV::cookie()['messages_cookies']) ||
                GV::cookie()['messages_cookies'] != 'true'
            ) &&
            Session::getUserId() === 0
        ) {
            return Tpl::view(PATH_TPL . 'index' . DS . 'messagesCookies.php');
        } else {
            return '';
        }
    }

    private function getTimeDifference(): string
    {
        if (Session::getTimeDifference() === null) {
            return TimeDifference::viewScript();
        } else {
            return '';
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}
