<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\ParamsToSql;
use Core\Plugins\Check\Item;
use Core\Plugins\Model\DB;

class ItemLang
{
    /**
     * Return needed languages item or false
     * @param array $params
     * @return array|false // array or false
     */
    public static function getItemLang(): array|false
    {
        return DB::getI()->getRow(
            [
                'table_name' => 'item_lang',
                'where'      => ParamsToSql::getSql(
                    $where = [
                        'item_id'  => Item::getI()->checkItem()['id'],
                        'cur_lang' => Item::getI()->checkItem()['lang']
                    ]
                ),
                'array'      => $where,
            ]
        );
    }
}
