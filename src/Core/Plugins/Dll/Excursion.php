<?php

namespace Core\Plugins\Dll;

use Core\Trl;

defined('AIW_CMS') or die;

class Excursion
{
    private static $instance = null;
    private $getAllStatusList = null;
    private $placeList = null;
    private $allType = null;

    private function __construct() {}

    public static function getI(): Excursion
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Get in array excursion place, where value is key
     * @return string
     */
    private function placeList(): array
    {
        if ($this->placeList === null) {
            $this->placeList = array_flip(require PATH_INC . 'excursion' . DS . 'place.php');
        }

        return $this->placeList;
    }
    /**
     * Return in string names excursion place
     * @param array $place
     * @return string
     */
    public function place(array $place): string
    {
        $placeHtml = '';

        foreach ($place as $key => $value) {
            $placeHtml .= Trl::_($this->placeList()[$value]) . ', ';
        }
        unset($key, $value);

        $placeHtml = mb_substr($placeHtml, 0, -2);

        return $placeHtml;
    }
    /**
     * Return all excursions types
     * @return array
     */
    private function allType(): array
    {
        if ($this->allType === null) {
            $this->allType = array_flip(require PATH_INC . 'excursion' . DS . 'type.php');
        }

        return $this->allType;
    }
    #

    public function type(int $type)
    {
        return Trl::_($this->allType()[$type]);
    }

    private $allTransport = null;
    /**
     * Return all excursions types
     * @return array
     */
    private function allTransport(): array
    {
        if ($this->allTransport === null) {
            $this->allTransport = array_flip(require PATH_INC . 'excursion' . DS . 'transport.php');
        }

        return $this->allTransport;
    }
    #
    public function transport(int $transport)
    {
        return Trl::_($this->allTransport()[$transport]);
    }
    /**
     * Return in array all excursion status list
     * @return array
     */
    public function getAllStatusList(): array
    {
        if ($this->getAllStatusList == null) {
            $this->getAllStatusList = require PATH_INC . 'excursion' . DS . 'status.php';
        }

        return $this->getAllStatusList;
    }
    #
    private function __clone() {}
    public function __wakeup() {}
}
