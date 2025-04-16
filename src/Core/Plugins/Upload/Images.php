<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

namespace Core\Plugins\Upload;

defined('AIW_CMS') or die;

use Core\{Auth, Config};
use Core\Plugins\{ParamsToSql, Model\DB, Msg};

class Images
{
    /**
     * Save all errors to this variable
     * @var string
     */
    private $msg = '';
    /**
     * Function images uploads
     * @param array $params
     * @return array
     */
    public function upload(array $params): array
    {
        /**
         * Get form values
         */
        $formValue = $params['form_value'];
        /**
         * Get images files
         */
        $files = $formValue[$params['input_name']];

        $pathItemCode = $this->pathItemCode(
            $params['items_date'],
            $params['dir_name'],
            $params['items_dir_code']
        ) . DS;

        $pathThumb  = $this->pathThumb($pathItemCode) . DS;
        $pathImg    = $this->pathImg($pathItemCode) . DS;

        $imgList = [];

        if ($this->countImagesInThisItem($params['items_id']) < Config::getCfg('CFG_MAX_IMAGES_IN_PHOTO_PRINT')) {

            foreach ($files as $file) {

                $parts = pathinfo($file['name']);

                $fileName = mb_substr(md5($file['name'] . $file['size']), 0, 16) . '.' . strtolower($parts['extension']);

                $currentImageParams = [
                    'author_id'      => (int) Auth::getUserId(),
                    'photo_print_id' => (int) $params['items_id'],
                    'image_name'     => (string) $fileName,
                    'crop_photo'     => (int) $formValue['crop_photo'],
                    'photo_size'     => (int) $formValue['photo_size'],
                    'papers_type'    => (int) $formValue['papers_type'],
                    'print_padding'  => (int) $formValue['print_padding'],
                    'copies_amount'  => (int) $formValue['copies_amount'],
                    'created'        => (int) time(),
                ];
                /**
                 * If current images file is present in images directory
                 */
                if (file_exists($pathImg . $fileName)) {
                    /**
                     * Check images entry in DB
                     */
                    $getAllCurrentImages = $this->getAllCurrentImages($fileName, $params['items_id']);
                    /**
                     * If NOT entry current images name in DB
                     */
                    if ($getAllCurrentImages == []) {
                        /**
                         * Save params current images to DB
                         */
                        if ($this->saveImagesParams($currentImageParams) === 0) {
                            /**
                             * If incorrect saves images print params to DB
                             */
                            $this->msg .= Msg::getMsgSprintf('danger', 'MSG_FAILED_WRITE_FILE_TO_DB', ...[$file['name']]);
                        }
                    }
                    /**
                     * If entry current images name in DB
                     */
                    else {

                        $currentImageCopy = false;
                        /**
                         * Check images params in DB and current image params
                         */
                        foreach ($getAllCurrentImages as $key => $value) {

                            if (
                                (int) $getAllCurrentImages[$key]['crop_photo']    === $currentImageParams['crop_photo'] &&
                                (int) $getAllCurrentImages[$key]['photo_size']    === $currentImageParams['photo_size'] &&
                                (int) $getAllCurrentImages[$key]['papers_type']   === $currentImageParams['papers_type'] &&
                                (int) $getAllCurrentImages[$key]['print_padding'] === $currentImageParams['print_padding']
                            ) {

                                $this->updateImageCopiesAmount(
                                    ($getAllCurrentImages[$key]['copies_amount'] + $currentImageParams['copies_amount']),
                                    $getAllCurrentImages[$key]['id']
                                );

                                $currentImageCopy = true;
                                break;
                            }
                        }

                        if ($currentImageCopy === false) {
                            /**
                             * Save params current images to DB
                             */
                            if ($this->saveImagesParams($currentImageParams) === 0) {
                                /**
                                 * If incorrect saves images print params to DB
                                 */
                                $this->msg .= Msg::getMsgSprintf('danger', 'MSG_FAILED_WRITE_FILE_TO_DB', ...[$file['name']]);
                            }
                        }
                    }

                    if (!file_exists($pathThumb . $fileName)) {
                        $this->thumbCreate($fileName, $pathImg, $pathThumb);
                    }
                }
                /**
                 * If current images file is NOT present in images directory
                 */
                else {
                    /**
                     * Move file to photo_prints directory
                     */
                    if (move_uploaded_file($file['tmp_name'], $pathImg . $fileName)) {
                        /**
                         * Save images prints parameters to DB
                         */
                        if ($this->saveImagesParams($currentImageParams) == 0) {
                            /**
                             * If incorrect saves images print params to DB
                             */
                            $this->msg .= Msg::getMsgSprintf('danger', 'MSG_FAILED_WRITE_FILE_TO_DB', ...[$file['name']]);
                        }


                        $this->thumbCreate($fileName, $pathImg, $pathThumb);
                    }
                    /**
                     * If incorrect move uploaded files
                     */
                    else {
                        $this->msg .= Msg::getMsgSprintf('danger', 'MSG_FAILED_WRITE_FILE_TO_DISK', ...[$file['name']]);
                    }
                }
            }
        }

        return $this->msg == '' ? $imgList : array_merge(['msg' => $this->msg], $imgList);
    }
    /**
     * Thumb created function
     * @param string $imgName
     * @param string $pathImg
     * @param string $thumbPath
     * @return boolean
     */
    public function thumbCreate(string $imgName, string $pathImg, string $thumbPath): bool
    {
        $msg = '';

        $imgFile = $pathImg . $imgName;
        $fileType = image_type_to_mime_type(exif_imagetype($imgFile));

        if ($fileType == 'image/jpeg') {
            $tmpFile = imagecreatefromjpeg($imgFile);
        } elseif ($fileType == 'image/png') {
            $tmpFile = imagecreatefrompng($imgFile);
        } elseif ($fileType == 'image/gif') {
            $tmpFile = imagecreatefromgif($imgFile);
        } else {
            $msg .= Msg::getMsgSprintf('danger', 'MSG_INVALID_FILE_TYPE', ...[$imgName]);
        }
        /**
         * Determine the width and height of the photo
         */
        $photoWidth  = (int) imagesx($tmpFile);
        $photoHeight = (int) imagesy($tmpFile);
        // Config::getCfg('CFG_MAX_THUMB_SIZE')
        if ($photoWidth >= $photoHeight) {
            $thumbWidth  = Config::getCfg('CFG_MAX_THUMB_SIZE');
            $thumbHeight = Config::getCfg('CFG_MAX_THUMB_SIZE') / 3 * 2;
        } else {
            $thumbWidth  = Config::getCfg('CFG_MAX_THUMB_SIZE') / 3 * 2;
            $thumbHeight = Config::getCfg('CFG_MAX_THUMB_SIZE');
        }
        /**
         * Determine the proportions of the final image
         */
        $proportions = (float) ($thumbWidth / $thumbHeight);

        require PATH_CORE . 'Plugins' . DS . 'Check' . DS . 'Require' . DS . 'NewImage' . DS . 'crop.php';
        /**
         * Crop the image according to the desired proportions
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
        $destination = $thumbPath . $imgName;
        $dest  = imagecreatetruecolor($thumbWidth, $thumbHeight);
        $color = imagecolorallocate($dest, 255, 255, 255);
        imagefilledrectangle($dest, 0, 0, $cropWidth, $cropHeight, $color);

        /**
         * Copying the old image to the new one with changing parameters
         */
        imagecopyresampled($dest, $tmpPhoto, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $cropWidth, $cropHeight);

        /**
         * Write image to server
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
            $this->msg .= $msg;
            return false;
        } else {
            return true;
        }
    }
    /**
     * Path YEAR created and get or get
     * @param integer $time
     * @param string  $uplDir
     * @return string
     */
    private function pathY(int $time, string $uplDir): string
    {
        $pathY = PATH_PUBLIC . $uplDir . DS . date("Y", $time);

        if (!is_dir($pathY)) {
            mkdir($pathY, 0775, true);

            $fp = fopen($pathY . DS . 'index.html', 'w+');
            fwrite($fp, '<!DOCTYPE html><title></title>');
            fclose($fp);
        }

        return $pathY;
    }
    /**
     * Path MONTH created and get or get
     * @param integer $time
     * @param string  $uplDir
     * @return string
     */
    private function pathM(int $time, string $uplDir): string
    {
        $pathM = $this->pathY($time, $uplDir) . DS . date("m", $time);

        if (!is_dir($pathM)) {
            mkdir($pathM, 0775, true);

            $fp = fopen($pathM . DS . 'index.html', 'w+');
            fwrite($fp, '<!DOCTYPE html><title></title>');
            fclose($fp);
        }

        return $pathM;
    }
    /**
     * Path DAY created and get or get
     * @param integer $time
     * @param string  $uplDir
     * @return string
     */
    private function pathD(int $time, string $uplDir): string
    {
        $pathD = $this->pathM($time, $uplDir) . DS . date("d", $time);

        if (!is_dir($pathD)) {
            mkdir($pathD, 0775, true);

            $fp = fopen($pathD . DS . 'index.html', 'w+');
            fwrite($fp, '<!DOCTYPE html><title></title>');
            fclose($fp);
        }

        return $pathD;
    }
    /**
     * Path ITEMS CODE created and get or get
     * @param integer $time
     * @param string  $uplDir
     * @param string  $code
     * @return string
     */
    public function pathItemCode(int $time, string $uplDir, string $code): string
    {
        $pathItemCode = $this->pathD($time, $uplDir) . DS . $code;

        if (!is_dir($pathItemCode)) {
            mkdir($pathItemCode, 0775, true);

            $fp = fopen($pathItemCode . DS . 'index.html', 'w+');
            fwrite($fp, '<!DOCTYPE html><title></title>');
            fclose($fp);
        }

        return $pathItemCode;
    }
    /**
     * Path IMAGES created and get or get
     * @param string $pathItemCode
     * @return string
     */
    private function pathImg(string $pathItemCode): string
    {
        $pathImg = $pathItemCode . 'img';

        if (!is_dir($pathImg)) {
            mkdir($pathImg, 0775, true);

            $fp = fopen($pathImg . DS . 'index.html', 'w+');
            fwrite($fp, '<!DOCTYPE html><title></title>');
            fclose($fp);
        }

        return $pathImg;
    }
    /**
     * THUMB path created and get or get
     * @param string $pathItemCode
     * @return string
     */
    private function pathThumb(string $pathItemCode): string
    {
        $pathThumb = $pathItemCode . 'thumb';

        if (!is_dir($pathThumb)) {
            mkdir($pathThumb, 0775, true);

            $fp = fopen($pathThumb . DS . 'index.html', 'w+');
            fwrite($fp, '<!DOCTYPE html><title></title>');
            fclose($fp);
        }

        return $pathThumb;
    }
    /**
     * Save image params to DB
     * @param array $imgParams
     * @return integer
     */
    private function saveImagesParams(array $imgParams): int
    {
        return DB::getI()->add(
            [
                'table_name' => 'photo_print_images',
                'set'        => ParamsToSql::getSet($imgParams),
                'array'      => $imgParams,
            ]
        );
    }
    /**
     * Get all images in current images name
     * @param string  $imgName
     * @param integer $photoPrintId
     * @return array // array or []
     */
    private function getAllCurrentImages(string $imgName, int $photoPrintId): array
    {
        return DB::getI()->getAll(
            [
                'table_name'          => 'photo_print_images',
                'where'               => ParamsToSql::getSql(
                    $where = [
                        'image_name' => $imgName,
                        'photo_print_id' => $photoPrintId,
                    ]
                ),
                'array'               => $where,
                'order_by_field_name' => 'id',
                'order_by_direction'  => 'ASC', // DESC
                'offset'              => 0,
                'limit'               => 0, // 0 - unlimited
            ]
        );
    }
    /**
     * Update image params "copies_amount"
     * @param integer $copiesAmount
     * @param integer $imageId
     * @return boolean
     */
    private function updateImageCopiesAmount(int $copiesAmount, int $imageId): bool
    {
        return DB::getI()->update(
            [
                'table_name' => 'photo_print_images',
                'set'        => ParamsToSql::getSet($set = ['copies_amount' => $copiesAmount]),
                'where'      => ParamsToSql::getSql($where = ['id' => $imageId]),
                'array'      => array_merge($set, $where),
            ]
        );
    }

    public function countImagesInThisItem(int $photoPrintId): int
    {
        return (int) DB::getI()->countFields(
            [
                'table_name' => 'photo_print_images',
                'field_name' => 'id',
                'where'      => ParamsToSql::getSql($where = ['photo_print_id' => $photoPrintId]),
                'array'      => $where,
            ]
        );
    }
}

// $params = [
//     'form_value'        => 'value',
//     'input_name'        => 'value',
//     'items_date'        => 'value',
//     'dir_name'          => 'value',
//     'items_dir_code'    => 'value',
//     'items_id'          => 'value',
// ];
