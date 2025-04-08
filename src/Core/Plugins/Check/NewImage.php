<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Core\Plugins\Check;

defined('AIW_CMS') or die;

use Core\GV;
use Core\Plugins\Msg;

class NewImage
{
    private $imageLink = [];

    public function getNewImageLink($params)
    {
        // $params = [
        //     'field_name' => 'FieldName', // Field name from download image
        //     'type'       => 'ImageProcessing', // crop, max_size
        //     'dir'        => 'ImageDirectory', // logo, intro
        //     'time'       => 'ContentCreatedTime', // Unix format time
        //     'id'         => 'ThisContentId', // This Content ID
        //     'width'      => 'ImageWidth', // Or maximum image width // px
        //     'height'     => 'ImageHeight', // Or maximum image height // px
        //     'max_size'   => 'ImageMaximumSizeBites', // bites
        // ];

        // (new \Core\Plugins\Check\NewImage)->getNewImageLink($params);

        if ($this->imageLink == []) {
            /**
             * If the $_FILES array is not empty
             */
            if (GV::files() !== null) {
                /**
                 * Get only array with key brand_logo
                 */
                $image = GV::files()[$params['field_name']];
                /**
                 * If the image is received with errors
                 * or not downloaded
                 */
                if ($image['error'] > 0) {
                    $this->imageLink['msg'] .= Msg::getMsg_('warning', 'INFO_INCORRECT_DOWNLOAD_IMAGE');
                } else {
                    /**
                     * If the image is loaded without errors
                     */
                    $errors    = [];
                    $fileName  = $image['name'];
                    $fileSize  = $image['size'];
                    $fileTmp   = $image['tmp_name'];
                    $fileType  = $image['type'];
                    $imageName = $image['name'];
                    $imageName = explode('.', $imageName);
                    $fileExt   = strtolower(end($imageName));

                    $extensions = ["jpeg", "jpg", "png", "gif"];

                    if ($fileSize > $params['max_size']) {
                        $this->imageLink['msg'] .= Msg::getMsg_('warning', 'INFO_INCORRECT_IMAGE_SIZE');
                    }

                    if (!in_array($fileExt, $extensions)) {
                        $this->imageLink['msg'] .= Msg::getMsg_('warning', 'INFO_INCORRECT_IMAGE_EXTENSION');
                    }

                    if (!isset($this->imageLink['msg'])) {
                        /**
                         * Determine the standard path to avatar files
                         * for this user
                         */
                        $data     = $params['time'];
                        $year     = userDate("Y", $data);
                        $month    = userDate("m", $data);
                        $day      = userDate("d", $data);
                        $hour     = userDate("H", $data);
                        $fileName = substr(md5($fileName . $fileSize), 20, 32) . '.' . $fileExt;

                        /**
                         * Create default folders and files
                         */
                        $destination = PATH_PUBLIC . 'img' . DS . $params['dir'] . DS . $year;
                        if (!file_exists($destination)) {
                            mkdir($destination, 0775, true);
                            $this->setIndexFile($destination);
                        }

                        $destination = $destination . DS . $month;
                        if (!file_exists($destination)) {
                            mkdir($destination, 0775, true);
                            $this->setIndexFile($destination);
                        }

                        $destination = $destination . DS . $day;
                        if (!file_exists($destination)) {
                            mkdir($destination, 0775, true);
                            $this->setIndexFile($destination);
                        }

                        $destination = $destination . DS . $hour;
                        if (!file_exists($destination)) {
                            mkdir($destination, 0775, true);
                            $this->setIndexFile($destination);
                        }

                        $destination = $destination . DS . $params['id'];
                        if (!file_exists($destination)) {
                            mkdir($destination, 0775, false);
                            $this->setIndexFile($destination);
                        }

                        $destination = $destination . DS . $fileName;

                        if (!file_exists($destination)) {

                            if ($fileType == 'image/jpeg') {
                                $tmpFile = imagecreatefromjpeg($fileTmp);
                            } elseif ($fileType == 'image/png') {
                                $tmpFile = imagecreatefrompng($fileTmp);
                            } elseif ($fileType == 'image/gif') {
                                $tmpFile = imagecreatefromgif($fileTmp);
                            } else {
                                $tmpFile = false;
                            }
                            /**
                             * Determine the proportions of the final image
                             */
                            $proportions = (float) ($params['width'] / $params['height']);

                            /**
                             * Determine the width and height photo
                             */
                            $photoWidth  = (int) imagesx($tmpFile);
                            $photoHeight = (int) imagesy($tmpFile);

                            if ($params['type'] == 'crop') {
                                require PATH_CORE . 'Plugins' . DS . 'Check' . DS . 'Require' . DS . 'NewImage' . DS . 'crop.php';
                            }
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
                            $dest  = imagecreatetruecolor($params['width'], $params['height']);
                            $color = imagecolorallocate($dest, 255, 255, 255);
                            imagefilledrectangle($dest, 0, 0, $cropWidth, $cropHeight, $color);
                            /**
                             * Copy the old image in the new with a change in parameters
                             */
                            imagecopyresampled($dest, $tmpPhoto, 0, 0, 0, 0, $params['width'], $params['height'], $cropWidth, $cropHeight);
                            /**
                             * Record the image on the server
                             */
                            if ($fileExt == 'jpeg' || $fileExt == 'jpg') {
                                imagejpeg($dest, $destination);
                            }

                            if ($fileExt == 'png') {
                                imagepng($dest, $destination);
                            }

                            if ($fileExt == 'gif') {
                                imagegif($dest, $destination);
                            }

                            imagedestroy($dest);
                        }

                        $this->imageLink['link'] = '/img/' . $params['dir'] . '/' . $year . '/' . $month . '/' . $day . '/' . $hour . '/' . $params['id'] . '/' . $fileName;
                    } else {
                        $this->imageLink['link'] = false;
                    }
                }
            } else {
                $this->imageLink['msg']  = Msg::getMsg_('warning', 'INFO_IMAGE_NOT_DOWNLOAD');
                $this->imageLink['link'] = '';
            }
        }

        return $this->imageLink;
    }

    private function setIndexFile($destination)
    {
        /**
         * Create an index file (if it does not exist)
         * To prevent access to the directory from the browser
         */
        $index = $destination . DS . 'index.html';
        if (!file_exists($index)) {
            $fp    = fopen($index, 'w+');
            $text  = '<!DOCTYPE html><title></title>';
            $write = fwrite($fp, $text);
            fclose($fp);
        }

        return $index;
    }
}
