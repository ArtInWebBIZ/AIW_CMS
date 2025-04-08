<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Upload;

defined('AIW_CMS') or die;

use Core\Plugins\Msg;
use Core\Plugins\Upload\Images;

// $params = [
//     'form_value'       => 'value', // Get form values
//     'input_name'       => 'value', // Get images files
//     'items_date'       => 'value', // 
//     'dir_name'         => 'value', // 
//     'items_id_or_code' => 'value', // 
//     'img_width'        => 'value', // 
//     'img_height'       => 'value', // 
// ];

class OneImage extends Images
{
    private $getImagePath = 'null';
    /**
     * Save all errors to this variable
     * @var array
     */
    private $msg = [
        'msg'       => '',
        'file_name' => '',
    ];
    /**
     * Function images uploads
     * Return image name in key ['file_name'] and empty key ['msg']
     * or 
     * @param array $params
     * @return array
     */
    public function uploadImage(array $params): array
    {
        /**
         * Get form values
         */
        $formValue = $params['form_value'];
        /**
         * Get images files
         */
        $file = $formValue[$params['input_name']];
        /**
         * Get images path
         */
        $imgPath = $this->getImagePath(
            [
                'items_date'       => $params['items_date'],
                'dir_name'  => $params['dir_name'],
                'items_id_or_code' => $params['items_id_or_code']
            ]
        ) . DS;
        /**
         * Returns information about a file path
         */
        $parts = pathinfo($file['name']);
        /**
         * Get new images file name
         */
        $fileName = mb_substr(md5($file['name'] . $file['size']), 0, 16) . '.' . strtolower($parts['extension']);
        /**
         * If current images file is present in images directory
         */
        if (file_exists($imgPath . $fileName)) {
            $this->msg['file_name'] = $fileName;
        }
        /**
         * If current images file is NOT present in images directory
         */
        else {
            /**
             * Move file to photo_prints directory
             */
            if (move_uploaded_file($file['tmp_name'], PATH_TMP . $fileName)) {

                $return = $this->imgCreate(
                    [
                        'img_name'   => $fileName,
                        'tmp_path'   => PATH_TMP,
                        'img_path'   => $imgPath,
                        'img_width'  => $params['img_width'],
                        'img_height' => $params['img_height'],
                    ]
                );

                if ($return === true) {
                    unlink(PATH_TMP . $fileName);
                    $this->msg['file_name'] = $fileName;
                } else {
                    $this->msg['msg'] .= $return;
                }
            }
            /**
             * If incorrect move uploaded files
             */
            else {
                $this->msg['msg'] .= Msg::getMsgSprintf('danger', 'MSG_FAILED_WRITE_FILE_TO_DISK', ...[$file['name']]);
            }
        }

        if ($this->msg['msg'] == '') {
            unset($this->msg['msg']);
        }

        return $this->msg;
    }
    /**
     * Get images path
     * @param array $params
     * @return string
     */
    private function getImagePath(array $params): string
    {
        if ($this->getImagePath === 'null') {

            $this->getImagePath = $this->pathItemCode(
                $params['items_date'],
                $params['dir_name'],
                $params['items_id_or_code']
            );
        }

        return $this->getImagePath;
    }
    /**
     * Image created function
     * @param array $params
     * @return mixed
     */
    private function imgCreate(array $params): mixed
    {
        // $params = [
        //     'img_name'   => '',
        //     'tmp_path'   => '',
        //     'img_path'   => '',
        //     'img_width'  => '',
        //     'img_height' => '',
        // ];
        $msg = '';

        $imgFile = $params['tmp_path'] . $params['img_name'];
        $fileType = image_type_to_mime_type(exif_imagetype($imgFile));

        if ($fileType == 'image/jpeg') {
            $tmpFile = imagecreatefromjpeg($imgFile);
        } elseif ($fileType == 'image/png') {
            $tmpFile = imagecreatefrompng($imgFile);
        } elseif ($fileType == 'image/gif') {
            $tmpFile = imagecreatefromgif($imgFile);
        } else {
            $msg .= Msg::getMsgSprintf('danger', 'MSG_INVALID_FILE_TYPE', ...[$params['img_name']]);
        }
        /**
         * Determine the width and height photo
         */
        $photoWidth  = (int) imagesx($tmpFile);
        $photoHeight = (int) imagesy($tmpFile);

        $imageWidth  = $params['img_width'];
        $imageHeight = $params['img_height'];
        /**
         * Determine the proportions of the final image
         */
        $proportions = (float) ($imageWidth / $imageHeight);

        require PATH_CORE . 'Plugins' . DS . 'Check' . DS . 'Require' . DS . 'NewImage' . DS . 'crop.php';
        /**
         * Cut the image according to the necessary proportions
         */
        $tmpPhoto = imagecrop(
            $tmpFile,
            [
                'x'      => $indentX,
                'y'      => $indentY,
                'width'  => $cropWidth,
                'height' => $cropHeight,
            ]
        );
        /**
         * Create an image of the desired name and size
         */
        $destination = $params['img_path'] . $params['img_name'];
        $dest  = imagecreatetruecolor($imageWidth, $imageHeight);
        $color = imagecolorallocate($dest, 255, 255, 255);
        imagefilledrectangle($dest, 0, 0, $cropWidth, $cropHeight, $color);
        /**
         * Copy the old image in the new with a change in parameters
         */
        imagecopyresampled($dest, $tmpPhoto, 0, 0, 0, 0, $imageWidth, $imageHeight, $cropWidth, $cropHeight);
        /**
         * Record the image on the server
         */
        if ($fileType == 'image/jpeg') {
            imagejpeg($dest, $destination);
        } elseif ($fileType == 'image/png') {
            imagepng($dest, $destination);
        } elseif ($fileType == 'image/gif') {
            imagegif($dest, $destination);
        }

        imagedestroy($dest);

        if ($msg !== '') {
            return $msg;
        } else {
            return true;
        }
    }
}
