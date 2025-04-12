<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\View;

defined('AIW_CMS') or die;

use Core\Plugins\{ParamsToSql, Model\DB, Ssl};
use Core\{App, Auth, BaseUrl, Languages, Config, DB as CoreDB, Session};

class ViewLog
{
    private static $getUrl = null;
    /**
     * Save to viewLog users viewed page
     * @param string $logTable
     * @return integer
     */
    public static function saveToLog(string $logTable): int
    {
        self::deleteOldLogs($logTable);

        $set = [
            'lang'    => array_search(Session::getLang(), Languages::langCodeList()),
            'url_id'  => self::getUrl()['id'],
            'user_ip' => ip2long(Session::getUserIp()),
            'token'   => substr(Session::getToken(), 0, 11),
            'created' => time(),
        ];

        if ($logTable != 'view_index_log') {
            $set['user_id'] = Auth::getUserId();
        }

        return DB::getI()->add(
            [
                'table_name' => $logTable,
                'set'        => ParamsToSql::getSet($set),
                'array'      => $set,
            ]
        );
    }
    /**
     * Get id viewed page
     * @return array
     */
    private static function getUrl(): array
    {
        if (self::$getUrl === null) {

            self::$getUrl = DB::getI()->getRow(
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

            if (self::$getUrl === false) {

                $getUrlId = DB::getI()->add(
                    [
                        'table_name' => 'list_page',
                        'set'        => ParamsToSql::getSet(
                            $set = [
                                'lang'          => Session::getLang(),
                                'url'           => BaseUrl::getOnlyUrl(),
                                'sitemap_order' => App::content()['sitemap_order'],
                                'created'       => time()
                            ]
                        ),
                        'array'      => $set,
                    ]
                );

                if (App::content()['sitemap_order'] > 0) {
                    self::saveToSitemap();
                }

                self::$getUrl = [
                    'id'            => $getUrlId,
                    'lang'          => Session::getLang(),
                    'url'           => BaseUrl::getOnlyUrl(),
                    'sitemap_order' => App::content()['sitemap_order'],
                    'created'       => time()
                ];
                #
            } elseif (
                (int) self::$getUrl['sitemap_order'] !== (int) App::content()['sitemap_order']
            ) {
                /**
                 * Update values in `list_page`
                 */
                DB::getI()->update(
                    [
                        'table_name' => 'list_page',
                        'set'        => ParamsToSql::getSet(
                            $set = ['sitemap_order' => App::content()['sitemap_order']]
                        ),
                        'where'      => ParamsToSql::getSql(
                            $where = ['id' => self::$getUrl['id']]
                        ),
                        'array'      => array_merge($set, $where),
                    ]
                );

                self::saveToSitemap();
                #
            }
        }

        return self::$getUrl;
    }
    /**
     * Delete old viewed log values
     * @param string $logTable
     * @return boolean
     */
    private static function deleteOldLogs(string $logTable): bool
    {
        return DB::getI()->delete(
            [
                'table_name' => $logTable,
                'where'      => '`created` < :created',
                'array'      => ['created' => time() - Config::getCfg('CFG_ENABLED_VIEW_LOG_TIME')],
            ]
        );
    }
    /**
     * Save page links to sitemap
     * @return void
     */
    private static function saveToSitemap()
    {
        /**
         * Save new sitemap
         */
        if (count(Languages::langList()) > 1) {
            $where = '`sitemap_order` > :sitemap_order';
            $array = ['sitemap_order' => 0];
        } else {
            $where = '`lang` = :lang AND `sitemap_order` > :sitemap_order';
            $array = [
                'lang'          => Session::getLang(),
                'sitemap_order' => 0
            ];
        }

        $pageToSitemap = CoreDB::getAll(
            "SELECT `lang`,`url` FROM `list_page` WHERE $where
            ORDER BY `sitemap_order` ASC, `id` DESC LIMIT 50000",
            $array
        );
        /**
         * Delete sitemap
         */
        $filename = PATH_PUBLIC . 'sitemap.txt';
        file_put_contents($filename, '');
        /**
         * Save new sitemap
         */
        $data     = '';
        foreach ($pageToSitemap as $key => $value) {
            if (count(Languages::langList()) > 1) {
                $data = Ssl::getLink() . '/' . $pageToSitemap[$key]['lang'] . '/' . $pageToSitemap[$key]['url'];
            } else {
                $data = Ssl::getLink() . '/' . $pageToSitemap[$key]['url'];
            }
            file_put_contents($filename, $data . "\r\n", FILE_APPEND | LOCK_EX);
        }
    }
}
