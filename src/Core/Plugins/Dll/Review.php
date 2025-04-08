<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Dll;

defined('AIW_CMS') or die;

use Core\Plugins\{ParamsToSql, Model\DB};
use Core\{Auth, Session};

class Review
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Review
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * @param string $text
     * @return integer // id or 0
     */
    public function add(array $params): int
    {
        return DB::getI()->add(
            [
                'table_name' => 'review',
                'set'        => ParamsToSql::getSet(
                    $set = [
                        'author_id' => Auth::getUserId(),
                        'lang'      => Session::getLang(),
                        'text'      => $params['text'],
                        'rating'    => $params['rating'],
                        'created'   => time(),
                        'edited'    => time(),
                    ]
                ),
                'array'      => $set,
            ]
        );
    }
    /**
     * @param integer $userId
     * @return array // array or []
     */
    public function latestUsersReview(int $userId): array
    {
        $return = DB::getI()->getNeededField(
            [
                'table_name'          => 'review',
                'field_name'          => 'id`,`created`,`status', // example 'id' or 'id`,`edited_count`,`brand_status'
                'where'               => ParamsToSql::getSql(
                    $where = ['author_id' => $userId]
                ),
                'array'               => $where,
                'order_by_field_name' => 'id',
                'order_by_direction'  => 'DESC', // DESC
                'offset'              => 0,
                'limit'               => 1, // 0 - unlimited
            ]
        );

        if ($return != []) {
            $return = $return[0];
        }

        return $return;
    }

    private function __clone() {}
    public function __wakeup() {}
}
