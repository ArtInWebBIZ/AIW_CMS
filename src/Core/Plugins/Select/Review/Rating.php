<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Select\Review;

defined('AIW_CMS') or die;

use Core\Trl;

class Rating
{
    private static $instance  = null;
    private static $allRatings = 'null';

    private function __construct()
    {
    }

    public static function getI(): Rating
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getAllRatings()
    {
        if (self::$allRatings == 'null') {
            self::$allRatings = require PATH_INC . 'review' . DS . 'rating.php';
        }

        return self::$allRatings;
    }

    public function clear()
    {
        return self::getAllRatings();
    }

    public function option($rating = null)
    {

        $variable = $this->clear();

        $rating = $rating === null ? $rating : (int) $rating;

        $selected = $rating === null ? ' selected="selected"' : '';

        $ratingHtml = '<option value=""' . $selected . '>' . Trl::_('OV_VALUE_NOT_SELECTED') . '</option>';

        foreach ($variable as $key => $value) {
            $selected = $value === $rating ? ' selected="selected"' : '';
            $ratingHtml .= '
            <option value="' . $value . '"' . $selected . '>' . $key . '</option>';
        }

        return $ratingHtml;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
