<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace PasteNameSpace; // VALUE IS EXAMPLE

use Core\Config;

defined('AIW_CMS') or die;

class ClassName // VALUE IS EXAMPLE
{

    private $saveIntroImage = null;
    /**
     * Save to server intro image
     * Return if success file name in key ['file_name']
     * Return if success empty key ['msg']
     * Return if error empty key ['file_name']
     * @return array
     */
    private function saveIntroImage(): array
    {
        if ($this->saveIntroImage === null) {

            $this->saveIntroImage = (new \Core\Plugins\Upload\OneImage)->uploadImage(
                [
                    'form_value'        => $this->checkForm(), // Get form values
                    'input_name'        => 'intro_img', // Get images files // VALUE IS EXAMPLE
                    'items_date'        => 'items_date_value', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
                    'upload_dir_name'   => Config::getCfg('CFG_INTRO_IMAGE_PATH'), // VALUE IS EXAMPLE
                    'items_id_or_code'  => 'items_id_or_code_value', // VALUE IS EXAMPLE !!! CHANGE_THIS !!!
                    'img_width'         => Config::getCfg('CFG_INTRO_IMAGE_WIDTH'), // VALUE IS EXAMPLE
                    'img_height'        => Config::getCfg('CFG_INTRO_IMAGE_HEIGHT'), // VALUE IS EXAMPLE
                ]
            );
        }

        return $this->saveIntroImage;
    }
}
