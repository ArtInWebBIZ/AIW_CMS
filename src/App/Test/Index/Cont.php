<?php

/**
 * @package    ArtInWebCMS.App
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Test\Index;

defined('AIW_CMS') or die;

use Core\{
    Content,
    // Languages,
    Session,
    Config,
    Auth,
    BaseUrl,
    Clean,
    DB as CoreDB,
    GV,
    Trl
};
use App\Test\Index\Req\Func;
use Core\Plugins\Select\Other\Languages;
use Core\Plugins\Crypt\CryptText;
use Core\Modules\View\MsgInTmp;
use Core\Plugins\View\Tpl;
use Core\Plugins\ParamsToSql;
use Core\Modules\Pagination\Pagination;
use App\PhotoPrint\View\Req\ZipCreate;
use Core\Modules\MainMenu\MainMenu;
use Core\Plugins\Model\DB;
use Core\Plugins\Ssl;
use Core\Plugins\Dll\User\NewUser;
use Core\Plugins\Dll\User;
use Core\Plugins\Name\Competition\Category;
use Core\Plugins\Save\ToLog;

class Cont
{
    private $content = [];

    public function getContent()
    {
        $this->content        = Content::getDefaultValue();
        $this->content['tpl'] = 'test';

        $config = require PATH_BASE . 'config.php';

        $this->content['content'] = $config;

        return $this->content;
    }
}
