<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Modules\Pagination;

defined('AIW_CMS') or die;

use Core\{BaseUrl, Clean, GV};

class Pagination
{
    private static $pagination    = '';
    private static $checkStartGet = null;

    public static function getPagination(int $count, int $paginationStep)
    {
        if (
            $count > $paginationStep
        ) {
            /**
             * The initial number of the displayed list
             */
            $startList = self::checkStartGet();
            /**
             * We determine how many times in the variable $count
             * the range of $paginationStep is placed
             */
            $pagesCount = (int) floor($count / $paginationStep);
            /**
             * We determine whether there is the rest of such a division
             */
            $paginationRest = $count % $paginationStep;
            /**
             * If there is the rest, we increase the variable
             * $pagesCount + 1
             */
            if ($paginationRest > 0) {
                $pagesCount = $pagesCount + 1;
            }
            /**
             * We check the correctness of the entered data $startList
             */
            if (
                $startList >= $count ||
                $startList < 0
            ) {
                $startList = 0;
            }
            /**
             * We determine the number of the active page
             */
            $activePage = (int) ($startList / $paginationStep) + 1;
            /**
             * We determine the correct initial number of display of the list
             */
            $startList = ($activePage - 1) * $paginationStep;
            /**
             * We form the conclusion of the pagination
             */
            self::$pagination = '<ul class="uk-pagination uk-flex uk-flex-center uk-flex-middle uk-margin">';
            /**
             * If the variable $startList = 0
             * We display an inactive link to the previous page
             */
            if ($startList == 0) {
                self::$pagination .= '<li class="uk-disabled"><a href=""><span uk-pagination-previous></span></a></li>';
            } else {
                self::$pagination .= '<li><a href="' . BaseUrl::getBaseUrl() . GV::addToGet(['start' => $startList - $paginationStep]) . '"><span uk-pagination-previous></span></a></li>';
            }
            /**
             * We form a paginations HTML code
             *
             * If pages of pagination are smaller or equal 9
             */
            if ($pagesCount <= 9) {

                for ($i = 1; $i <= $pagesCount; $i++) {

                    if ($i == $activePage) {
                        self::$pagination .= '<li class="uk-active"><span>' . $i . '</span></li>';
                    } else {
                        self::$pagination .= self::getStandardLi($i, $paginationStep);
                    }
                }
            }
            /**
             * If the pages of the pagination are larger 9-ти
             */
            else {

                if ($activePage <= 5) {

                    for ($i = 1; $i <= 7; $i++) {

                        if ($i == $activePage) {
                            self::$pagination .= '<li class="uk-active"><span>' . $i . '</span></li>';
                        } else {
                            self::$pagination .= self::getStandardLi($i, $paginationStep);
                        }
                    }

                    self::$pagination .= '<li class="uk-text-muted"><span>...</span></li>';
                    self::$pagination .= self::getStandardLi($pagesCount, $paginationStep);
                    #
                } elseif ($activePage >= ($pagesCount - 4)) {

                    self::$pagination .= self::getStandardLi(1, $paginationStep);
                    self::$pagination .= '<li class="uk-text-muted"><span>...</span></li>';

                    for ($i = ($pagesCount - 6); $i <= $pagesCount; $i++) {

                        if ($i == $activePage) {

                            self::$pagination .= '<li class="uk-active"><span>' . $i . '</span></li>';
                        } else {

                            self::$pagination .= self::getStandardLi($i, $paginationStep);
                        }
                    }
                    #
                } else {

                    self::$pagination .= self::getStandardLi(1, $paginationStep);
                    self::$pagination .= '<li class="uk-text-muted"><span>...</span></li>';
                    self::$pagination .= self::getStandardLi(($activePage - 2), $paginationStep);
                    self::$pagination .= self::getStandardLi(($activePage - 1), $paginationStep);
                    self::$pagination .= '<li class="uk-active"><span>' . $activePage . '</span></li>';
                    self::$pagination .= self::getStandardLi(($activePage + 1), $paginationStep);
                    self::$pagination .= self::getStandardLi(($activePage + 2), $paginationStep);
                    self::$pagination .= '<li class="uk-text-muted"><span>...</span></li>';
                    self::$pagination .= self::getStandardLi($pagesCount, $paginationStep);
                }
            }
            /**
             * Determine the link to the next page
             */
            if (($count - $startList) > $paginationStep) {
                self::$pagination .= '<li><a href="' . BaseUrl::getBaseUrl() . GV::addToGet(['start' => $startList + $paginationStep]) . '"><span uk-pagination-next></span></a></li>';
            } else {
                self::$pagination .= '<li class="uk-disabled"><a href=""><span uk-pagination-next></span></a></li>';
            }
            /**
             * The end of the pagination unit
             */
            self::$pagination .= '</ul>';
        } else {
            self::$pagination = '';
        }

        return self::$pagination;
    }
    /**
     * Get start items count from global $_GET variable
     * @return integer
     */
    public static function checkStartGet(): int
    {
        if (isset(GV::get()['start'])) {

            self::$checkStartGet = Clean::unsInt(GV::get()['start']);

            if (!is_int(self::$checkStartGet)) {
                self::$checkStartGet = 0;
            }
            #
        } else {
            self::$checkStartGet = 0;
        }

        return self::$checkStartGet;
    }
    /**
     * Get correctly paginations link
     * @param integer $i
     * @param integer $paginationStep
     * @return string
     */
    private static function getStandardLi(int $i, int $paginationStep): string
    {
        return '<li><a href="' . BaseUrl::getBaseUrl() . GV::addToGet(['start' => ($i * $paginationStep) - $paginationStep]) . '">' . $i . '</a></li>';
    }
}
