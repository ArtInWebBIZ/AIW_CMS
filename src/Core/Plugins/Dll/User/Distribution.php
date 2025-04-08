<?php

namespace Core\Plugins\Dll\User;

defined('AIW_CMS') or die;

use Core\Plugins\Dll\User;
use Core\Config;
use Core\Plugins\Model\DB;
use Core\Plugins\ParamsToSql;
use Core\Plugins\Crypt\CryptText;
use Core\Trl;
use Core\Plugins\Ssl;

class Distribution extends User
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Distribution
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Undocumented function
     * @param integer $userId
     * @param float   $sumToPaid
     * @param string  $typeCode
     * @param integer $contentId
     * @return bool
     */
    public function feeDistribution(int $userId, float $sumToPaid, string $typeCode, int $contentId): bool
    {
        $percents = $sumToPaid * Config::getCfg('CFG_CASH_BACK_RATIO');
        $end      = false;

        do {
            $currentUser = $this->getUserDistributionFromId($userId);
            $currentUser = $currentUser[0];

            $currentUser['parent_id'] =  0;

            $parentUser = $this->getUserDistributionFromId($currentUser['parent_id']);
            $parentUser = $parentUser[0];

            $params = [
                'current_user' => $currentUser,
                'parent_user'  => $parentUser,
                'percents'     => $percents,
                'type_code'    => $typeCode,
                'content_id'   => $contentId,
            ];

            $this->paidFrom($params);
            $this->paidTo($params);

            $percents = $percents * Config::getCfg('CFG_CASH_BACK_RATIO');
            $userId   = $parentUser['id'];

            $floatPercents = round($percents, 2);

            if (
                $floatPercents <= 0 ||
                $userId == 0
            ) {
                $end = true;
            }
            #
        } while ($end == false);

        return $end;
    }
    /**
     * Return in array users 
     * @param integer $userId
     * @return array
     */
    private function getUserDistributionFromId(int $userId): array
    {
        return DB::getI()->getNeededField(
            [
                'table_name'          => 'user',
                'field_name'          => 'id`,`parent_id`,`balance', // example 'id' or 'id`,`edited_count`,`brand_status'
                'where'               => '`id` = :id',
                'array'               => ['id' => $userId],
                'order_by_field_name' => 'id',
                'order_by_direction'  => 'ASC',
                'offset'              => 0,
                'limit'               => 1,
            ]
        );
    }

    private function paidFrom(array $params)
    {
        $this->updUserFromParams(
            [
                'balance' => round(($params['current_user']['balance'] - $params['percents']), 2),
                'edited'  => time(),
            ],
            ['id' => $params['current_user']['id']]
        );

        $this->saveToEditLog(
            [
                'edited_id'    => $params['current_user']['id'],
                'editor_id'    => $params['current_user']['id'],
                'edited_field' => 'balance',
                'old_value'    => round($params['current_user']['balance'], 2),
                'new_value'    => round(($params['current_user']['balance'] - $params['percents']), 2),
                'edited'       => time(),
            ]
        );

        $this->saveToUserBalanceEditLog(
            [
                'user_id'    => $params['current_user']['id'],
                'type_code'  => $params['type_code'],
                'content_id' => $params['content_id'],
                'paid_to'    => $params['parent_user']['id'],
                'paid_from'  => $params['current_user']['id'],
                'paid_sum'   => round(- ($params['percents']), 2),
                'paid_type'  => 2,
                'old_value'  => round($params['current_user']['balance'], 2),
                'new_value'  => round(($params['current_user']['balance'] - $params['percents']), 2),
                'edited'     => time(),
            ]
        );
    }

    private function paidTo(array $params)
    {
        $oldUsersBalance = round($params['parent_user']['balance'], 2);
        $newUsersBalance = round(($params['parent_user']['balance'] + $params['percents']), 2);
        /**
         * Save to user hear new balance
         */
        $this->updUserFromParams(
            [
                'balance' => $newUsersBalance,
                'edited'  => time(),
            ],
            ['id' => $params['parent_user']['id']]
        );
        /**
         * Save update user balance to log
         */
        $this->saveToEditLog(
            [
                'edited_id'    => $params['parent_user']['id'],
                'editor_id'    => $params['current_user']['id'],
                'edited_field' => 'balance',
                'old_value'    => $oldUsersBalance,
                'new_value'    => $newUsersBalance,
                'edited'       => time(),
            ]
        );
        /**
         * Send users message about next balance status stage
         */
        foreach ($this->getEmailMsgStage() as $key => $value) {

            if (
                $oldUsersBalance < (float) $this->getEmailMsgStage()[$key] &&
                $newUsersBalance >= (float) $this->getEmailMsgStage()[$key]
            ) {
                /**
                 * Get users email
                 */
                $email = DB::getI()->getNeededField(
                    [
                        'table_name'          => 'user',
                        'field_name'          => 'user',
                        'where'               => ParamsToSql::getSql(
                            $where = ['id' => $params['parent_user']['id']]
                        ),
                        'array'               => $where,
                        'order_by_field_name' => 'id',
                        'order_by_direction'  => 'ASC',
                        'offset'              => 0,
                        'limit'               => 1,
                    ]
                );

                $email = json_decode($email[0]['user'], true);

                (new \Core\Modules\Email)->sendEmail(
                    CryptText::getI()->textDecrypt($email['email']),
                    Trl::_('EMAIL_BALANCE_STAGE_SUBJECT'),
                    Trl::sprintf('EMAIL_BALANCE_STAGE_TEXT', ...[
                        $value,
                        Config::getCfg('CFG_CURRENCY_SHORT_NAME')
                    ]) . '<br><br><a href="' . Ssl::getLinkLang() . 'user/my-balance/">' . Ssl::getLinkLang() . 'user/my-balance/</a>'
                );

                break;
            }
        }
        /**
         * Save edited params to balance edit log
         */
        $this->saveToUserBalanceEditLog(
            [
                'user_id'    => $params['parent_user']['id'],
                'type_code'  => $params['type_code'],
                'content_id' => $params['content_id'],
                'paid_to'    => $params['parent_user']['id'],
                'paid_from'  => $params['current_user']['id'],
                'paid_sum'   => round($params['percents'], 2),
                'paid_type'  => 1,
                'old_value'  => $oldUsersBalance,
                'new_value'  => $newUsersBalance,
                'edited'     => time(),
            ]
        );
    }

    private function __clone() {}
    public function __wakeup() {}
}
