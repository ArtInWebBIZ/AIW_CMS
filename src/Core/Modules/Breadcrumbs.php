<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Modules;

use Core\App;
use Core\BaseUrl;
use Core\Router;
use Core\Trl;

defined('AIW_CMS') or die;

class Breadcrumbs
{
    private static $instance = null;

    private function __construct() {}

    public static function getI(): Breadcrumbs
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $getHtml = 'null';
    /**
     * Return …
     * @return string
     */
    public function getHtml(): string
    {
        if ($this->getHtml == 'null') {

            if (
                Router::getRoute()['controller_url'] != '' &&
                Router::getRoute()['action_url'] != ''
            ) {

                $this->getHtml = '
                <nav class="uk-background-default">
                    <div class="uk-flex uk-flex-center uk-flex-middle nav-div">
                        ' . $this->getBreadcrumbList() . '
                    </div>
                </nav>';
                #
            } else {
                $this->getHtml = '';
            }
        }

        return $this->getHtml;
    }

    private $getBreadcrumbList = 'null';
    /**
     * Return …
     * @return string
     */
    private function getBreadcrumbList(): string
    {
        if ($this->getBreadcrumbList == 'null') {

            if (
                Router::getRoute()['controller_url'] != ''
            ) {
                $mainLink = '
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="' . BaseUrl::getLangToLink() . '">
                <span itemprop="name">' . Trl::_($this->ControllersList()['Main']) . '</span>
                <meta itemprop="position" content="1" />
            </a>
        </li>';
            } else {
                $mainLink = '';
            }

            if (
                Router::getRoute()['action_name'] == 'View' ||
                (
                    Router::getRoute()['controller_url'] != '' &&
                    Router::getRoute()['action_url'] != '')

            ) {
                $controllerName = isset($this->ControllersList()[Router::getRoute()['controller_name']]) ?
                    Trl::_($this->ControllersList()[Router::getRoute()['controller_name']]) : 'UNKNOWN';

                $controllerLink = '
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="' . BaseUrl::getLangToLink() . Router::getRoute()['controller_url'] . '/">
            <span itemprop="name">' . $controllerName . '</span>
            <meta itemprop="position" content="2" />
            </a>
        </li>';
            } else {
                $controllerLink = '';
            }

            if (
                Router::getRoute()['action_url'] != '' &&
                Router::getRoute()['page_alias'] != ''
            ) {
                $actionName = isset($this->ControllersList()[Router::getRoute()['action_name']]) ?
                    Trl::_($this->ControllersList()[Router::getRoute()['action_name']]) : 'UNKNOWN';

                $actionLink = '
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="' . BaseUrl::getLangToLink() . '">
                <span itemprop="name">' . $actionName . '</span>
                <meta itemprop="position" content="3" />
            </a>
        </li>';
            } else {
                $actionLink = '';
            }

            $this->getBreadcrumbList = '
        <ul itemscope itemtype="http://schema.org/BreadcrumbList" class="uk-breadcrumb uk-margin-remove">
            ' . $mainLink . $controllerLink . $actionLink . '
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">' . Trl::_(App::content()['title']) . '</span>
            </li>
        </ul>
        ';
        }

        return $this->getBreadcrumbList;
    }

    private $ControllersList = null;
    /**
     * Return …
     * @return array
     */
    private function ControllersList(): array
    {
        if ($this->ControllersList == null) {
            $this->ControllersList = require PATH_INC . 'breadcrumbs' . DS . 'controllersList.php';
        }

        return $this->ControllersList;
    }

    private function __clone() {}
    public function __wakeup() {}
}
