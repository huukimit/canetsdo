<?php

namespace App\Models\Media;

use Cache,
    Input,
    Validator;
use App\BaseModel;
use URL;

class Media extends BaseModel {

    function __construct() {
        parent::__construct();
    }

    /**
     *
     * @return lay ra chuoi random
     */
    static function randomString() {
        $length = 10;
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);
        return $randomString;
    }

    /**
     *
     * @param type $file
     * @param type $folder
     * @return Upload image
     */
    static function uploadImage($file, $folder) {
        $data = $file;
        if (is_array($data['file'])) {
            if (is_uploaded_file($data['file']['tmp_name'])) {
                $original = $data['file']['tmp_name'];
                $max_width = 1200;
                $max_height = 1200;
                $url_upload = 'public/uploads/media/' . $folder . '/';

                $url_link = URL::to('/') . '/public/uploads/media/' . $folder . '/';

                // begin by getting the details of the original
                list($width, $height, $type) = getimagesize($original);
                // calculate the ratio
                if ($width > $max_width && $height > $max_height) {
                    $ratio = $max_width / $width;
                } elseif ($width > $height && $width > $max_width) {
                    $ratio = $max_width / $width;
                } elseif ($width < $height && $height > $max_height) {
                    $ratio = $max_height / $height;
                } else {
//                    $ratio = $max_height / $height;
                    $ratio = 1;
                }
                // strip the extension off the image
                $fileName = explode(".", $data['file']['name']);
                $imagetypes = array('/\\.gif$/', '/\\.jpg$/', '/\\.jpeg$/', '/\\.png$/');
                $name = preg_replace($imagetypes, '', basename($original));
//                $outName = $folder . '_' . $name . '.' . last($fileName);
                $outName = $folder . '_' . rand() . '.' . last($fileName);
                $targetPath = $url_upload . $outName;

                // create an image resource from the original
                switch ($type) {
                    case 1:
                        $source = @imagecreatefromgif($original);
                        if (!$source) {
                            $result = 'Cannot the process the GIF file. Please use JPEG or PNG.';
                        }
                        break;
                    case 2:
                        $source = @imagecreatefromjpeg($original);
                        break;
                    case 3:
                        $source = @imagecreatefrompng($original);
                        break;
                    default:
                        $source = NULL;
                        $result = 'Cannot identify file type.';
                }
                // make sure the file is OK
                if (!$source) {
                    $result = 'Problem copying the original';
                } else {
                    // calculate the dimension of the tumbnail
                    $thumb_width = round($width * $ratio);
                    $thumb_height = round($height * $ratio);
                    // create an image resource for the thumbnail
                    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
                    // create the resized of the copy
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
                    // save the resized copy
                    switch ($type) {
                        case 1:
                            if (function_exists('imagegif')) {
                                $success = imagegif($thumb, $targetPath);
                            } else {
                                $success = imagejpeg($thumb, $targetPath);
                            }
                            break;
                        case 2:
                            $success = imagejpeg($thumb, $targetPath);
                            break;
                        case 3:
                            $success = imagepng($thumb, $targetPath);
                    }
                    if ($success) {
                        imagedestroy($source);
                        imagedestroy($thumb);
                        $size_image = self::getSizeImage($url_link . $outName);
                        return array(
                            'url' => $url_upload . $outName,
                            'size_image' => $size_image
                        );
                    } else {
                        imagedestroy($source);
                        imagedestroy($thumb);
                        // remove the image resources from memory
                    }
                }
            }
        }
    }

    /**
     *
     * @param type $file
     * @param type $folder
     * @return upload image array
     */
    static function uploadArrayImage($file, $folder) {
        $data = $file;
        if (is_array($data['image'])) {
            $result = array();
            for ($i = 0; $i < count($data['image']['name']); $i++) {
                $image['file'] = array(
                    'name' => $data['image']['name'][$i],
                    'type' => $data['image']['type'][$i],
                    'tmp_name' => $data['image']['tmp_name'][$i],
                    'error' => $data['image']['error'][$i],
                    'size' => $data['image']['size'][$i]
                );
                $result[] = self::uploadImage($image, 'news');
            }
        }
        return $result;
    }

    /**
     *
     * @param type $file
     * @param type $folder
     * @return Upload video
     */
    static function uploadVideo($file, $folder) {
        $data = $file;
        if (is_array($data['file_video'])) {
            if (is_uploaded_file($data['file_video']['tmp_name'])) {
                $url_upload = 'public/uploads/media/' . $folder . '/';
                $url_link = URL::to('/') . '/public/uploads/media/' . $folder . '/';
                // strip the extension off the image
                $fileName = explode(".", $data['file_video']['name']);
                $outName = 'video_' . rand() . '.' . last($fileName);
                $targetPath = $url_upload . $outName;
                if (move_uploaded_file($data['file_video']['tmp_name'], $targetPath)) {
                    return $url_upload . $outName;
                } else {
                    unlink($targetPath);
                }
            }
        }
    }

    /**
     *
     * @param type $file
     * @param type $folder
     * @return Upload item
     */
    static function uploadItem($file, $folder) {
        $data = $file;
        if (is_array($data['file'])) {
            if (is_uploaded_file($data['file']['tmp_name'])) {
                $url_upload = 'public/uploads/media/' . $folder . '/';
                $url_link = URL::to('/') . '/public/uploads/media/' . $folder . '/';
                // strip the extension off the image
                $fileName = explode(".", $data['file']['name']);
                $outName = $folder . '_' . rand() . '.' . last($fileName);
                $targetPath = $url_upload . $outName;
                if (move_uploaded_file($data['file']['tmp_name'], $targetPath)) {
                    $size_image = self::getSizeImage($url_link . $outName);
                    return array(
                        'url' => $url_upload . $outName,
                        'size_image' => $size_image
                    );
                } else {
                    unlink($targetPath);
                }
            }
        }
    }

    static function uploadImageBase64($file, $folder) {
        $url_upload = 'public/uploads/media/' . $folder . '/';
        $url_link = URL::to('/') . '/public/uploads/media/' . $folder . '/';
        $img = str_replace('data:image/png;base64,', '', $file);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $outName = $folder . '_' . rand() . '.png';
        $out = $url_upload . $outName;
        $success = file_put_contents($out, $data);
        if ($success) {
            $size_image = self::getSizeImage($url_link . $outName);
            return array(
                'url' => $out,
                'size_image' => $size_image
            );
        }
    }

    /**
     *
     * @param type $url
     * @return Get full link
     */
    static function getUrl($url) {
        return $url != '' ? URL::to('/') . '/' . $url : '';
    }

    /**
     * Get size of image
     */
    static function getSize($json_param) {
        return $json_param != '' ? json_decode($json_param) : '';
    }

    /**
     *
     * @param type $url
     * @return get size image
     */
    static function getSizeImage($url) {
        list($width, $height, $type) = @getimagesize($url);
        $result = array(
            'width' => '',
            'height' => ''
        );
        $result['width'] = $width > 0 ? $width : '';
        $result['height'] = $height > 0 ? $height : '';
        return $result;
    }

    static function getAvatar($url) {
        return $url != '' ? URL::to('/') . '/' . $url : URL::to('/') . '/public/uploads/default/avatar.png';
    }

    /**
     *
     * @param type $id_post
     * @return Link to detail post
     */
    static function getLinkDetailPost($id_post) {
        return URL::to('/') . '/detailfeed.html?id=' . $id_post;
    }

}
