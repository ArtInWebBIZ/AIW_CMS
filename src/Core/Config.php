<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core;

defined('AIW_CMS') or die;

use Core\Plugins\Model\DB;

class Config
{
    private static $config = null;
    /**
     * Return all config array
     * @return array
     */
    private static function setConfig()
    {
        if (self::$config === null) {

            $config = require_once PATH_BASE . 'config.php';

            $fromDB = DB::getI()->getAll(
                [
                    'table_name'          => 'config_control',
                    'where'               => '`id` > :id',
                    'array'               => ['id' => 0],
                    'order_by_field_name' => 'id',
                    'order_by_direction'  => 'ASC', // DESC
                    'offset'              => 0,
                    'limit'               => 0, // 0 - unlimited
                ]
            );

            foreach ($fromDB as $key => $value) {
                if ($fromDB[$key]['value_type'] == 'int') {
                    $toConfig[$fromDB[$key]['params_name']] = (int) $fromDB[$key]['params_value'];
                } elseif ($fromDB[$key]['value_type'] == 'float') {
                    $toConfig[$fromDB[$key]['params_name']] = (float) $fromDB[$key]['params_value'];
                } elseif ($fromDB[$key]['value_type'] == 'string') {
                    $toConfig[$fromDB[$key]['params_name']] = (string) $fromDB[$key]['params_value'];
                } elseif ($fromDB[$key]['value_type'] == 'boolean') {
                    $toConfig[$fromDB[$key]['params_name']] = (bool) $fromDB[$key]['params_value'];
                } else {
                    $toConfig[$fromDB[$key]['params_name']] = $fromDB[$key]['params_value'];
                }
            }

            self::$config = array_merge($config, $toConfig);

            unset($config, $fromDB, $toConfig);
        }

        return self::$config;
    }
    /**
     * Return concreted configuration parameter
     * @param [string] $name
     * @return string
     */
    public static function getCfg(string $name)
    {
        return isset(self::setConfig()[$name]) ? self::setConfig()[$name] : die('Incorrect config key ' . '"' . $name . '"');
    }
}
