<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('AIW_CMS') or die;

/**
 * Determine the proportions of the image processing
 * and indentation of cutting along the axes
 */
/**
 * Square
 */
if (
    $photoWidth == $photoHeight // Square
    && $proportions == 1
) {

    $indentX    = 0;
    $indentY    = 0;
    $cropWidth  = $photoWidth;
    $cropHeight = $photoHeight;
} elseif (
    $photoWidth > $photoHeight // Landscape
    && $proportions == 1 // Square
) {

    $indentX    = round(($photoWidth - $photoHeight) / 2);
    $indentY    = 0;
    $cropWidth  = $photoHeight;
    $cropHeight = $photoHeight;
} elseif (
    $photoWidth < $photoHeight // Portrait
    && $proportions == 1 // Square
) {

    $indentX    = 0;
    $indentY    = round(($photoHeight - $photoWidth) / 2);
    $cropWidth  = $photoWidth;
    $cropHeight = $photoWidth;
}
/**
 *  Landscape
 */
elseif (
    $photoWidth == $photoHeight // Square
    && $proportions > 1 // Landscape
) {

    $tmpHeight  = round($photoWidth / $proportions);
    $indentX    = 0;
    $indentY    = round(($photoHeight - $tmpHeight) / 2);
    $cropWidth  = $photoWidth;
    $cropHeight = $tmpHeight;
} elseif (
    $photoWidth > $photoHeight // Landscape
    && $proportions > 1 // Landscape
) {

    $tmpWidth = round($photoHeight * $proportions);

    if ($tmpWidth == $photoWidth) {
        $indentX    = 0;
        $indentY    = 0;
        $cropWidth  = $photoWidth;
        $cropHeight = $photoHeight;
    } elseif ($tmpWidth > $photoWidth) {
        $tmpHeight  = round($photoWidth / $proportions);
        $indentX    = 0;
        $indentY    = round(($photoHeight - $tmpHeight) / 2);
        $cropWidth  = $photoWidth;
        $cropHeight = $tmpHeight;
    } else {
        $indentX    = round(($photoWidth - $tmpWidth) / 2);
        $indentY    = 0;
        $cropWidth  = $tmpWidth;
        $cropHeight = $photoHeight;
    }
} elseif (
    $photoWidth < $photoHeight // Portrait
    && $proportions > 1 // Landscape
) {

    $tmpHeight  = round($photoWidth / $proportions);
    $indentX    = 0;
    $indentY    = round(($photoHeight - $tmpHeight) / 2);
    $cropWidth  = $photoWidth;
    $cropHeight = $tmpHeight;
}
/**
 * Portrait
 */
elseif (
    $photoWidth == $photoHeight //Square
    && $proportions < 1 // Portrait
) {

    $tmpWidth   = round($photoWidth * $proportions);
    $indentX    = round(($photoWidth - $tmpWidth) / 2);
    $indentY    = 0;
    $cropWidth  = $tmpWidth;
    $cropHeight = $photoHeight;
} elseif (
    $photoWidth > $photoHeight // Landscape
    && $proportions < 1 // Portrait
) {

    $tmpWidth   = round($photoHeight * $proportions);
    $indentX    = round(($photoWidth - $tmpWidth) / 2);
    $indentY    = 0;
    $cropWidth  = $tmpWidth;
    $cropHeight = $photoHeight;
} elseif (
    $photoWidth < $photoHeight // Portrait
    && $proportions < 1 // Portrait
) {

    $tmpWidth = round($photoHeight * $proportions);

    if ($tmpWidth > $photoWidth) {
        $tmpHeight  = round($photoWidth / $proportions);
        $indentX    = 0;
        $indentY    = round(($photoHeight - $tmpHeight) / 2);
        $cropWidth  = $photoWidth;
        $cropHeight = $tmpHeight;
    } elseif ($tmpWidth == $photoWidth) {
        $indentX    = 0;
        $indentY    = 0;
        $cropWidth  = $photoWidth;
        $cropHeight = $photoHeight;
    } else {
        $indentX    = round(($photoWidth - $tmpWidth) / 2);
        $indentY    = 0;
        $cropWidth  = $tmpWidth;
        $cropHeight = $photoHeight;
    }
}
