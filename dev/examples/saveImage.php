<?php

/**
 * @package    ArtInWebCMS.example
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

private $saveIntroImage = 'null';
    /**
     * Save to server intro image
     * Return if success empty key ['msg']
     * Return if error empty key ['file_name']
     * @return array
     */
    private function saveIntroImage(): array
    {
        if ($this->saveIntroImage == 'null') {

            $this->saveIntroImage = (new \Core\Plugins\Upload\OneImage)->uploadImage(
                [
                    'form_value'        => $this->checkForm(), // Get form values
                    'input_name'        => 'intro_img', // Get images files
                    'items_date'        => $this->newPostTime(), // 
                    'upload_dir_name'   => Config::getCfg('CFG_INTRO_IMAGE_PATH'), // 
                    'items_id_or_code'  => $this->saveNewItem(), // 
                    'img_width'         => Config::getCfg('CFG_INTRO_IMAGE_WIDTH'), // 
                    'img_height'        => Config::getCfg('CFG_INTRO_IMAGE_HEIGHT'), // 
                ]
            );
        }

        return $this->saveIntroImage;
    }
