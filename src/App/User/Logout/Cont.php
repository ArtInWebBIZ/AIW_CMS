<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace App\User\Logout;

defined('AIW_CMS') or die;

use Core\{Content, Session};
use Core\Plugins\{ParamsToSql, Model\DB};
use App\User\Logout\Req\Func;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content = Content::getDefaultValue();

        $where = ['session_key' => Session::getSession()['session_key']];

        DB::getI()->delete(
            [
                'table_name' => 'session',
                'where'      => ParamsToSql::getSql($where),
                'array'      => $where,
            ]
        );

        $this->content['redirect'] = Func::getI()->referer();

        return $this->content;
    }
}
