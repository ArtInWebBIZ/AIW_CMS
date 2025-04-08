<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
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
             * Начальное число отображаемого списка
             */
            $startList = self::checkStartGet();
            /**
             * Определяем, сколько раз в переменной $count
             * помещается диапазон $paginationStep
             */
            $pagesCount = (int) floor($count / $paginationStep);
            /**
             * Определяем, есть ли остаток такого деления
             */
            $paginationRest = $count % $paginationStep;
            /**
             * Если остаток есть, увеличиваем переменную
             * $pagesCount на единицу
             */
            if ($paginationRest > 0) {
                $pagesCount = $pagesCount + 1;
            }
            /**
             * Проверяем корректность введенных данных $startList
             */
            if (
                $startList >= $count ||
                $startList < 0
            ) {
                $startList = 0;
            }
            /**
             * Определяем номер активной страницы
             */
            $activePage = (int) ($startList / $paginationStep) + 1;
            /**
             * Определяем корректное начальное число отображения списка
             */
            $startList = ($activePage - 1) * $paginationStep;
            /**
             * Формируем вывод пагинации
             */
            self::$pagination = '<ul class="uk-pagination uk-flex uk-flex-center uk-flex-middle uk-margin">';
            /**
             * Если переменная $startList = 0
             * выводим неактивную ссылку на предыдущую страницу
             */
            if ($startList == 0) {
                self::$pagination .= '<li class="uk-disabled"><a href=""><span uk-pagination-previous></span></a></li>';
            } else {
                self::$pagination .= '<li><a href="' . BaseUrl::getBaseUrl() . GV::addToGet(['start' => $startList - $paginationStep]) . '"><span uk-pagination-previous></span></a></li>';
            }
            /**
             * Формируем html-код пагинации
             *
             * Если страниц пагинации меньше или равно 9
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
             * Если страниц пагинации больше 9-ти
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
             * Определяем ссылку на следующую страницу
             */
            if (($count - $startList) > $paginationStep) {
                self::$pagination .= '<li><a href="' . BaseUrl::getBaseUrl() . GV::addToGet(['start' => $startList + $paginationStep]) . '"><span uk-pagination-next></span></a></li>';
            } else {
                self::$pagination .= '<li class="uk-disabled"><a href=""><span uk-pagination-next></span></a></li>';
            }
            /**
             * Конец блока пагинации
             */
            self::$pagination .= '</ul>';
        } else {
            self::$pagination = '';
        }

        return self::$pagination;
    }

    public static function checkStartGet()
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

    private static function getStandardLi($i, $paginationStep)
    {
        return '<li><a href="' . BaseUrl::getBaseUrl() . GV::addToGet(['start' => ($i * $paginationStep) - $paginationStep]) . '">' . $i . '</a></li>';
    }
}
