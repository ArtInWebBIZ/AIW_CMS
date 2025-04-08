<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Item;

defined('AIW_CMS') or die;

use Core\Plugins\{Ssl, ParamsToSql, Model\DB};
use Core\{Session, Router, Content};

class ControlClear
{
    private $content = [];

    public function getContent()
    {
        $this->content = Content::getDefaultValue();

        /**
         * Удаляем запись фильтров из БД
         */
        DB::getI()->delete(
            [
                'table_name' => 'control_post_note',
                'where'      => ParamsToSql::getSql(
                    $where = [
                        'token'           => Session::getToken(),
                        'controller_name' => Router::getRoute()['controller_name'],
                        'action_name'     => str_replace("Clear", "", Router::getRoute()['action_name']),
                    ]
                ),
                'array'      => $where,
            ]
        );
        /**
         * Перенаправляем на страницу управления
         */
        $this->content['redirect'] = Ssl::getLinkLang() . Router::getRoute()['controller_url'] . '/' . str_replace("-clear", "", Router::getRoute()['action_url']) . '/';


        return $this->content;
    }
}
