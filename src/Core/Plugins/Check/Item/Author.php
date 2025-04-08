<?php

namespace Core\Plugins\Check\Item;

defined('AIW_CMS') or die;

use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\Check\Item;
use Core\Plugins\Crypt\CryptText;
use Core\Trl;

class Author
{
    private static $author     = null;
    private static $authorName = 'null';
    /**
     * Return full name author this item
     * @return array
     */
    private static function author(): array
    {
        if (self::$author == null) {
            /**
             * Get authors data from database
             */
            $data = DB::getI()->getValue(
                [
                    'table_name' => 'user',
                    'select'     => 'user',
                    'where'      => ParamsToSql::getSql(
                        $where = [
                            'id' => Item::getI()->checkItem()['author_id'],
                        ]
                    ),
                    'array'      => $where,
                ]
            );
            /**
             * Decode json
             */
            $data = json_decode($data, true);
            $data['name']        = CryptText::getI()->textDecrypt($data['name']);
            $data['middle_name'] = CryptText::getI()->textDecrypt($data['middle_name']);
            $data['surname']     = CryptText::getI()->textDecrypt($data['surname']);
            $data['phone']       = CryptText::getI()->textDecrypt($data['phone']);
            unset($data['email']);
            self::$author = $data;
            unset($data);
        }

        return self::$author;
    }
    /**
     * Return …
     * @return string
     */
    public static function authorName(): string
    {
        if (self::$authorName == 'null') {

            self::$authorName = '';
            self::$authorName .= self::author()['name'] == '' ? '' : self::author()['name'] . ' ';
            self::$authorName .= self::author()['middle_name'] == '' ? '' : self::author()['middle_name'] . ' ';
            self::$authorName .= self::author()['surname'] == '' ? '' : self::author()['surname'];

            self::$authorName = trim(self::$authorName) != '' ? trim(self::$authorName) : Trl::_('USER_USER') . ' #' . Item::getI()->checkItem()['author_id'];
        }

        return self::$authorName;
    }
}
