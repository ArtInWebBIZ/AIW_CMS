<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Create\User;

defined('AIW_CMS') or die;

use Core\{Config, Session};
use Core\Modules\Randomizer;
use Core\Plugins\Create\GetHash\GetHash;
use Core\Plugins\{ParamsToSql, Model\DB, Crypt\CryptText,};

class StartedUser
{
    public function newUsers(): void
    {
        $names = [
            'namesMan'      => require PATH_INC . 'user' . DS . 'names' . DS . 'uk' . DS . 'man.php',
            'lastnameMan'   => require PATH_INC . 'user' . DS . 'names' . DS . 'uk' . DS . 'lastnameMan.php',
            'namesWoman'    => require PATH_INC . 'user' . DS . 'names' . DS . 'uk' . DS . 'woman.php',
            'lastnameWoman' => require PATH_INC . 'user' . DS . 'names' . DS . 'uk' . DS . 'lastnameWoman.php',
            'surname'       => require PATH_INC . 'user' . DS . 'names' . DS . 'uk' . DS . 'surname.php',
        ];

        $getLatestUsersId = $this->getLatestUsersId()['id'];
        $created          = $this->getLatestUsersId()['created'];

        $maxUser = 250;

        for ($i = 0; $i < $maxUser; $i++) {

            $created = $created + random_int(0, 14400);

            if ($created >= time()) {
                break;
            }

            $sex = random_int(0, 1) == 0 ? 'Man' : 'Woman';

            $keyName    = 'names' . $sex;
            $countName  = count($names[$keyName]);
            $newNameKey = random_int(0, ($countName - 1));
            $userName   = $names[$keyName][$newNameKey];

            $keyLastname    = 'lastname' . $sex;
            $countLastname  = count($names[$keyLastname]);
            $newLastnameKey = random_int(0, ($countLastname - 1));
            $userLastname   = $names[$keyLastname][$newLastnameKey];

            $countSurname = count($names['surname']);
            $newSurname   = random_int(0, ($countSurname - 1));
            $userSurname  = $names['surname'][$newSurname];

            do {

                $newRefCode = Randomizer::getRandomStr(
                    Config::getCfg('CFG_MIN_REF_CODE_LEN'),
                    Config::getCfg('CFG_MAX_REF_CODE_LEN')
                );

                $parentId = DB::getI()->getValue(
                    [
                        'table_name' => 'user',
                        'select'     => 'id',
                        'where'      => '`ref_code` = :ref_code',
                        'array'      => ['ref_code' => $newRefCode],
                    ]
                );
                #
            } while ($parentId !== null);

            do {

                $newPhone = random_int(380100000000, 380299999999);

                $id = DB::getI()->getValue(
                    [
                        'table_name' => 'user',
                        'select'     => 'id',
                        'where'      => '`phone_hash` = :phone_hash',
                        'array'      => ['phone_hash' => $newPhone],
                    ]
                );
                #
            } while ($id !== null);

            $set = [
                'parent_id'    => random_int(0, ($getLatestUsersId + $i)),
                'ref_code'     => $newRefCode,
                'group'        => 2,
                'email_hash'   => GetHash::getEmailHash('user' . ($getLatestUsersId + $i + 1) . '@test.com'),
                'phone_hash'   => GetHash::getDefHash($newPhone),
                'user'         => json_encode(
                    [
                        'name'        => CryptText::getI()->textEncrypt($userName),
                        'middle_name' => CryptText::getI()->textEncrypt($userLastname),
                        'surname'     => CryptText::getI()->textEncrypt($userSurname),
                        'phone'       => CryptText::getI()->textEncrypt($newPhone),
                        'email'       => CryptText::getI()->textEncrypt('user' . ($getLatestUsersId + $i + 1) . '@test.com'),
                    ]
                ),
                'password'     => GetHash::getPassHash('user' . ($getLatestUsersId + $i + 1) . '@test.com'),
                'created'      => $created,
                'edited'       => $created,
                'latest_visit' => $created,
                'lang'         => Session::getLang(),
                'status'       => 1,
            ];

            DB::getI()->add(
                [
                    'table_name' => 'user',
                    'set'        => ParamsToSql::getSet($set),
                    'array'      => $set,
                ]
            );
        }
    }

    private $getLatestUsersId = 'null';

    private function getLatestUsersId()
    {
        if ($this->getLatestUsersId == 'null') {

            $this->getLatestUsersId = DB::getI()->getNeededField(
                [
                    'table_name'          => 'user',
                    'field_name'          => 'id`,`created', // example 'id' or 'id`,`edited_count`,`brand_status'
                    'where'               => '`id` > :id',
                    'array'               => ['id' => 0],
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => 'DESC', // DESC
                    'offset'              => 0,
                    'limit'               => 1, // 0 - unlimited
                ]
            );

            $this->getLatestUsersId = $this->getLatestUsersId[0];
        }

        return $this->getLatestUsersId;
    }
}
